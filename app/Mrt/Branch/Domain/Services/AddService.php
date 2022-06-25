<?php

namespace App\Mrt\Branch\Domain\Services;

use App\Mrt\Branch\Domain\Repositories\BranchRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{
    public $name = "branch";

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $branch = $this->repository->create($data);
        if($branch != null)
            return new SuccessPayload(__("New branch success added"));

        throw new MainException("Error to add");
    }

}