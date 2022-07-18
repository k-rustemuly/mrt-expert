<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Mrt\Patient\Domain\Repositories\PatientRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        if(!$data["iin"] || strlen($data["iin"]) != 12) 
        { 
            $data["iin"] = $this->repository->getLastGeneratedIin();
            $data["is_iin_generated"] = true;
        }
        $data["phone_number"] = preg_replace('/[^0-9]/', '', $data["phone_number"]);
        $patient = $this->repository->create($data);
        if($patient != null)
            return new SuccessPayload(__("New patient success added"), $patient->id);

        throw new MainException("Error to add new patient");
    }

}