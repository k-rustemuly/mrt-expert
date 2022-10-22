<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Order\Domain\Repositories\OrderRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mrt\Upload\Domain\Repositories\UploadRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;

class SubmitForDoctorService
{

    protected $repository;

    protected $orderRepository;

    protected $uploadRepository;

    protected $doctorRepository;

    public function __construct(Repository $repository, OrderRepository $orderRepository, UploadRepository $uploadRepository, DoctorRepository $doctorRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
        $this->uploadRepository = $uploadRepository;
        $this->doctorRepository = $doctorRepository;
    }

    public function handle($suborder_id = 0, $data = array())
    {
        $user = auth('doctor')->user();
        $doctor_id = $user->id;
        $data["status_id"] = SuborderStatus::COMPLETED;
        $suborder = $this->repository->submitByDoctor($doctor_id, $suborder_id, $data);
        if($suborder != null)
        {
            $aboutSuborder = $this->repository->getAllByDoctorId($doctor_id, $suborder_id);
            $aboutOrder = $this->orderRepository->getById($aboutSuborder["order_id"]);
            $aboutDoctor = $this->doctorRepository->getById($doctor_id);
            $branch_id = $aboutSuborder["branch_id"];
            $data["service_name"] = $aboutSuborder["service_name"];
            $data["subservice_name"] = $aboutSuborder["subservice_name"];
            $data["full_name"] = $aboutOrder["patient_name"];
            $data["birthday"] = $aboutOrder["birthday"];
            $data["appointment_date"] = $aboutSuborder["appointment_date"];
            $data["doctor_name"] = $aboutDoctor["full_name"];
            $pdf = Pdf::loadView('mrt', $data);
            $filename = Str::orderedUuid().".pdf";
            $path = 'pdf/'.$filename;
            Storage::put($path, $pdf->output());
            $url = Storage::url($path);
            $uuid = Str::orderedUuid();
            $upload_id = $this->uploadRepository->create([
                "uuid" => $uuid,
                "name" => $filename,
                "path" => $path,
                "extension" => "pdf",
                "url" => $url
            ])["id"];
            $this->repository->updateConclusion($suborder_id, $upload_id);

            $order_id = $aboutSuborder["order_id"];
            $suborders = $this->repository->getAllByOrderId($order_id);
            $send_sms = true;
            foreach ($suborders as $suborder)
            {
                if(
                    (isset($suborder->status_id) && $suborder->status_id != SuborderStatus::COMPLETED) ||
                    (isset($suborder["status_id"]) && $suborder["status_id"] != SuborderStatus::COMPLETED))
                {
                    $send_sms = false;
                }
            }
            $route= "sfdfds";
            if($send_sms)
            {
                $auth_info = $this->orderRepository->getAuthById($order_id);
                $phone_number = $auth_info["phone_number"];
                $login = $auth_info["login"];
                $password = $auth_info["password"];
                $message = __("Patient sms", ["login" => $login, "password" => $password]);
                $smsc = config('integration.smsc')["route"];
                $route = $smsc."&phones=".$phone_number."&mes=".urlencode($message);
                Http::get($route);
            }
            return new SuccessPayload(__("Suborder success updated"), $route);
        }

        throw new MainException("Error to update suborder");
    }

}
