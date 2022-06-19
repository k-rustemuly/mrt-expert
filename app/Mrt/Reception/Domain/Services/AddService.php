<?php

namespace App\Mrt\Reception\Domain\Services;

use App\Mrt\Reception\Domain\Repositories\ReceptionRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $user = auth('branche_admin')->userOrFail();
        $data["branche_id"] = $user->branche_id;
        $password = Str::random(8);
        $data["password"] = Hash::make($password);
        $reception = $this->repository->create($data);
        if($reception != null)
            return new SuccessPayload(__("New reception success added"));

        throw new MainException("Error to add new reception");
    }

}