<?php

namespace App\Mrt\Doctor\Domain\Services;

use App\Mrt\Doctor\Domain\Repositories\DoctorRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\Hash;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $data["password"] = Hash::make($data["password"]);
        $doctor = $this->repository->create($data);
        if($doctor != null)
            return new SuccessPayload(__("New doctor success added"));

        throw new MainException("Error to add new doctor");
    }

}