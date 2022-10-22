<?php

namespace App\Mrt\Order\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class SubserviceDeleteService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $order_id ID
     */
    public function handle($order_id = 0, $suborder_id = 0)
    {
        $user = auth('reception')->user();
        if(!$user){
            $user = auth('assistant')->user();
        }
        $branch_id = $user->branch_id;
        if(!$this->repository->deleteByBranchId($branch_id, $order_id, $suborder_id))
        {
            throw new MainException("Error to delete suborder");
        }
        return new SuccessPayload(__("Success deleted suborder"));
    }
}
