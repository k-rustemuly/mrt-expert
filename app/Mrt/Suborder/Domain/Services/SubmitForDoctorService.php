<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;

class SubmitForDoctorService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
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
            $branch_id = $aboutSuborder["branch_id"];
            
            //TODO: generate pdf and send sms
            return new SuccessPayload(__("Suborder success updated"));
        }

        throw new MainException("Error to update suborder");
    }

}