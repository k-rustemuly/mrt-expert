<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class UpdateAssistantService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($suborder_id = 0, $data = [])
    {
        $user = auth('assistant')->user();
        $branch_id = $user->branch_id;
        $suborder = $this->repository->updateByBranchId($branch_id, $suborder_id,$data);
        if($suborder != null)
            return new SuccessPayload(__("Suborder success updated"));

        throw new MainException("Error to update suborder");
    }

}