<?php

namespace App\Mrt\Branch\Domain\Services;

use App\Mrt\Branch\Domain\Repositories\BranchRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SaveService
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($branch_id = 0 , $data = [])
    {
        $branch = $this->repository->updateById($branch_id, $data);
        if($branch != null)
            return new SuccessPayload(__("Branch success saved"));

        throw new MainException("Error saving");
    }

}