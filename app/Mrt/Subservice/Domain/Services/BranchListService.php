<?php

namespace App\Mrt\Subservice\Domain\Services;

use App\Domain\Services\Service;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository as Repository;
use App\Domain\Payloads\GenericPayload;

class BranchListService extends Service
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($branch_id = 0)
    {
        $data = $this->repository->getAllByBranch($branch_id);
        return new GenericPayload($data);
    }

}