<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class TreatmentAllForDoctorService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $user = auth('doctor')->user();
        $doctor_id = $user->id;
        $suborder = $this->repository->acceptAllByDoctor($doctor_id);
        if($suborder != null)
            return new SuccessPayload(__("Suborder success updated"));
        throw new MainException("Error to update suborder");
    }

}
