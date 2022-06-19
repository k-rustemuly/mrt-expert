<?php

namespace App\Mrt\Admin\Domain\Services;

use App\Mrt\Admin\Domain\Repositories\AdminRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SaveService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($admin_id = 0, $data = [])
    {
        $admin = $this->repository->updateById($admin_id, $data);
        if($admin != null)
            return new SuccessPayload(__("Admin success saved"));

        throw new MainException("Error to save admin");
    }

}