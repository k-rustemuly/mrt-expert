<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\Order\Domain\Models\OrderStatus;
use App\Mrt\Order\Domain\Repositories\OrderRepository;

class AddService
{

    protected $repository;

    protected $orderRepository;

    public function __construct(Repository $repository, OrderRepository $orderRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
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
        if($suborder != null){
            $this->orderRepository->updateById($order_id, ["status_id" => OrderStatus::REGISTERED]);
            return new SuccessPayload(__("New suborder success added"));
        }

        throw new MainException("Error to add new suborder");
    }

}
