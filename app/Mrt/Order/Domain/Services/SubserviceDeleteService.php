<?php

namespace App\Mrt\Order\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\Order\Domain\Models\OrderStatus;
use Illuminate\Support\Facades\Http;
use App\Mrt\Order\Domain\Repositories\OrderRepository;

class SubserviceDeleteService
{

    protected $repository;

    protected $orderRepository;

    public function __construct(Repository $repository, OrderRepository $orderRepository)
    {
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
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
        $others = $this->repository->getAllOtherSubordersOrderId($order_id, $suborder_id);
        if(empty($others)){
            $this->orderRepository->updateById($order_id, ["status_id" => OrderStatus::DRAFF]);
        }else{
            $completed = true;
            foreach($others as $suborder){
                if((isset($suborder->status_id) && $suborder->status_id != SuborderStatus::COMPLETED) || (isset($suborder["status_id"]) && $suborder["status_id"] != SuborderStatus::COMPLETED)){
                    $completed = false;
                    break;
                }
            }
            if($completed){
                $auth_info = $this->orderRepository->getAuthById($order_id);
                $phone_number = $auth_info["phone_number"];
                $login = $auth_info["login"];
                $password = $auth_info["password"];
                $message = __("Patient sms", ["login" => $login, "password" => $password]);
                $smsc = config('integration.smsc')["route"];
                $route = $smsc."&phones=".$phone_number."&mes=".urlencode($message);
                Http::get($route);
                $this->orderRepository->updateById($order_id, ["status_id" => OrderStatus::COMPLETED]);
            }
        }
        return new SuccessPayload(__("Success deleted suborder"));
    }
}
