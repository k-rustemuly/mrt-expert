<?php

namespace App\Mrt\Reception\Domain\Services;

use App\Mrt\Reception\Domain\Repositories\ReceptionRepository as Repository;
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
        $user = auth('branch_admin')->user();
        $data["branch_id"] = $user->branch_id;
        $data["password"] = Hash::make($data["password"]);
        $reception = $this->repository->create($data);
        if($reception != null)
            return new SuccessPayload(__("New reception success added"));

        throw new MainException("Error to add new reception");
    }

}