<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($order_id = 0, $data = [])
    {
        $user = auth('reception')->user();
        if(!$user){
            $user = auth('assistant')->user();
        }
        $branch_id = $user->branch_id;
        $data["branch_id"] = $branch_id;
        $data["order_id"] = $order_id;
        $suborder = $this->repository->create($data);
        if($suborder != null)
            return new SuccessPayload(__("New suborder success added"));

        throw new MainException("Error to add new suborder");
    }

}
