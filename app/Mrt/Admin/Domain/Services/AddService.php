<?php

namespace App\Mrt\Admin\Domain\Services;

use App\Mrt\Admin\Domain\Repositories\AdminRepository as Repository;
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

    public function handle($branch_id = 0, $data = [])
    {
        $data["branch_id"] = $branch_id;
        $data["password"] = Hash::make($data["password"]);
        $admin = $this->repository->create($data);
        if($admin != null)
            return new SuccessPayload(__("New admin success added"));

        throw new MainException("Error to add new admin");
    }

}