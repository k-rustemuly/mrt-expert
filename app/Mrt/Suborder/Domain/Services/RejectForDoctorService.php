<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class RejectForDoctorService
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
        $comment = null;
        if(isset($data["doctor_comment"])) $comment = $data["doctor_comment"];
        $suborder = $this->repository->rejectByDoctor($doctor_id, $suborder_id, $comment);
        if($suborder != null)
            return new SuccessPayload(__("Suborder success updated"));

        throw new MainException("Error to update suborder");
    }

}