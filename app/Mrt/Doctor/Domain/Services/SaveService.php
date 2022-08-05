<?php

namespace App\Mrt\Doctor\Domain\Services;

use App\Mrt\Doctor\Domain\Repositories\DoctorRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\Hash;

class SaveService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($doctor_id = 0, $data = [])
    {
        $data["subservices"] = "@".implode('@', $data["subservices"])."@";
        if(isset($data["password"]))
        {
            $data["password"] = Hash::make($data["password"]);
        }

        $doctor = $this->repository->updateById($doctor_id, $data);
        if($doctor != null)
            return new SuccessPayload(__("Doctor success saved"));

        throw new MainException("Error to save Doctor");
    }

}