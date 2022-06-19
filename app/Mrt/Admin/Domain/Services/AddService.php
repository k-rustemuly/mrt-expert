<?php

namespace App\Mrt\Admin\Domain\Services;

use App\Mrt\Admin\Domain\Repositories\AdminRepository as Repository;
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

    public function handle($branche_id = 0, $data = [])
    {
        $data["branche_id"] = $branche_id;
        $password = Str::random(8);
        $data["password"] = Hash::make($password);
        $admin = $this->repository->create($data);
        if($admin != null)
            return new SuccessPayload(__("New admin success added"));

        throw new MainException("Error to add new admin");
    }

}