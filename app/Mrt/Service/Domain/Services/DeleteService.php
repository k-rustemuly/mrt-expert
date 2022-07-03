<?php

namespace App\Mrt\Service\Domain\Services;

use App\Mrt\Service\Domain\Repositories\BranchSubServiceRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class DeleteService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($id = 0)
    {
        $user = auth('branch_admin')->user();
        $subservice = $this->repository->deleteByBranchId($user->branch_id, $id);
        if($subservice != null)
            return new SuccessPayload(__("Subservice success deleted"));
        throw new MainException("Error to delete subservice");
    }

}