<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Mrt\Order\Domain\Repositories\OrderRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mrt\Upload\Domain\Repositories\UploadRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mrt\Doctor\Domain\Repositories\DoctorRepository;
use Carbon\Carbon;

class EditConclusionService
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
        $data["status_id"] = SuborderStatus::COMPLETED;
        $suborder = null;
        if($user){
            $doctor_id = $user->id;
            $suborder = $this->repository->submitByDoctor($doctor_id, $suborder_id, $data);
        }else{
            $user = auth('reception')->user();
            if($user){
                $branch_id = $user->branch_id;
                $suborder = $this->repository->submitByBranchId($branch_id, $suborder_id, $data);
            }
        }
        if($suborder != null)
        {
            $aboutSuborder = $this->repository->getMinInfo($suborder_id);
            $aboutOrder = $this->orderRepository->getById($aboutSuborder["order_id"]);
            $aboutDoctor = $this->doctorRepository->getById(substr($aboutSuborder["doctors"], 1, -1));
            $data["service_name"] = $aboutSuborder["service_name"];
            $data["subservice_name"] = $aboutSuborder["subservice_name"];
            $data["full_name"] = $aboutOrder["patient_name"];
            $data["birthday"] = $aboutOrder["birthday"];
            $data["appointment_date"] = $aboutSuborder["appointment_date"];
            $data["doctor_name"] = $aboutDoctor["full_name"];
            $pdf = Pdf::loadView('mrt', $data);
            $uuid = Str::orderedUuid();
            $filename = $data["full_name"]." ".$uuid.".pdf";
            $date = Carbon::parse($aboutSuborder["created_at"])->format('Y/m/d');
            $path = 'pdf/'.$date.'/'.$filename;
            Storage::put($path, $pdf->output());
            $url = Storage::url($path);
            $upload_id = $this->uploadRepository->create([
                "uuid" => $uuid,
                "name" => $filename,
                "path" => $path,
                "extension" => "pdf",
                "url" => $url
            ])["id"];
            $this->repository->updateConclusion($suborder_id, $upload_id);
            return new SuccessPayload(__("Suborder success updated"));
        }

        throw new MainException("Error to update suborder");
    }

}
