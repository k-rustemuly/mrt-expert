<?php

namespace App\Mrt\Service\Domain\Services;

use App\Mrt\Service\Domain\Repositories\BranchSubServiceRepository as Repository;
use App\Domain\Payloads\SuccessPayload;
use App\Exceptions\MainException;

class AddService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $user = auth('branch_admin')->user();
        $insert = ["branch_id" => $user->branch_id, "subservice_id" => $data["subservice_id"]];
        $subservice = $this->repository->create($insert);
        if($subservice != null)
            return new SuccessPayload(__("New subservice success added"));

        throw new MainException("Error to add new subservice");
    }

}