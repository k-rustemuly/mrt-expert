<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Mrt\Patient\Domain\Repositories\PatientRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SaveService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($patient_id = 0, $data = [])
    {
        $patient = $this->repository->updateById($patient_id, $data);
        if($patient != null)
            return new SuccessPayload(__("Patient success saved"));

        throw new MainException("Error to save Patient");
    }

}