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
        if($data["iin"] || strlen($data["iin"]) != 12) $data["iin"] = $this->repository->getLastGeneratedIin();

        $patient = $this->repository->create($data);
        if($patient != null)
            return new SuccessPayload(__("New patient success added"), ["id" => $patient->id]);

        throw new MainException("Error to add new patient");
    }

}