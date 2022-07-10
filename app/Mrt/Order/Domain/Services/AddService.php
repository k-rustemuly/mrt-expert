<?php

namespace App\Mrt\Order\Domain\Services;

use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\Patient\Domain\Repositories\LoginRepository;
use App\Mrt\Patient\Domain\Repositories\PatientRepository;

class AddService
{

    protected $repository;

    protected $loginRepository;

    protected $patientRepository;

    public $patient_id;

    public function __construct(Repository $repository, LoginRepository $loginRepository, PatientRepository $patientRepository)
    {
        $this->repository = $repository;
        $this->loginRepository = $loginRepository;
        $this->patientRepository = $patientRepository;
    }

    public function handle($patient_id = 0)
    {
        $this->patient_id = $patient_id;
        $user = auth('reception')->user();
        $branch_id = $user->branch_id;
        $reception_id = $user->id;
        $patient_login_id = $this->getAuthDataPatient();
        $insert = ["branch_id" => $branch_id, "patient_id" => $this->patient_id, "reception_id" => $reception_id, "patient_login_id" => $patient_login_id]; 
        $order = $this->repository->create($insert);
        if($order != null)
            return new SuccessPayload(__("New order success added"), $order->id);

        throw new MainException("Error to add new order");
    }

    private function getAuthDataPatient()
    {
        $randomLogin = (string)random_int(0, 999999);
        $randomPassword = (string)random_int(0, 999999);
        if(strlen($randomLogin) < 6)
        {
            for($i=0;$i<strlen($randomLogin); $i++)
            {
                $randomLogin = "0".$randomLogin;
            }
        }
        if($this->loginRepository->exists($randomLogin, $randomPassword))
        {
            return $this->getAuthDataPatient();
        }
        $patient = $this->patientRepository->getById($this->patient_id);
        $data["full_name"] = $patient["full_name"];
        $data["login"] = $randomLogin;
        $data["password"] = $randomPassword;
        $data["to_inactive"] = date('Y-m-d H:i:s', strtotime("+180 days"));

        return $this->loginRepository->create($data)->id;
    }
}