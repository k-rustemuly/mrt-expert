<?php

namespace App\Mrt\Order\Domain\Services;

use App\Mrt\Order\Domain\Repositories\OrderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($patient_id = 0)
    {
        $user = auth('reception')->user();
        $branch_id = $user->branch_id;
        $reception_id = $user->id;
        $insert = ["branch_id" => $branch_id, "patient_id" => $patient_id, "reception_id" => $reception_id]; 
        $order = $this->repository->create($insert);
        if($order != null)
            return new SuccessPayload(__("New order success added"), $order->id);

        throw new MainException("Error to add new order");
    }

}