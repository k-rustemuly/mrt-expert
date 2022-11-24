<?php

namespace App\Mrt\Suborder\Domain\Services;

use App\Mrt\Suborder\Domain\Repositories\SuborderRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;

class CancelService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($suborder_id = 0, $data = [])
    {
        $user = auth('reception')->user();
        $who = "reception";
        if(!$user){
            $user = auth('assistant')->user();
            $who = "assistant";
        }
        $branch_id = $user->branch_id;
        $update["status_id"] = SuborderStatus::CANCELED;
        $update[$who."_comment"] = $data["cancel_comment"];
        $suborder = $this->repository->revoke($branch_id, $suborder_id, $update);
        if($suborder != null)
            return new SuccessPayload(__("Suborder success updated"));

        throw new MainException("Error to update suborder");
    }

}
