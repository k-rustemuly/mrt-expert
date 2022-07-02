<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Mrt\Patient\Domain\Repositories\PatientRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class ExistService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        return new SuccessPayload("", $this->repository->existsByIin($data["iin"]));
    }

}