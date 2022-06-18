<?php

namespace App\Edus\Commissions\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Commissions\Domain\Repositories\CommissionRepository as Repository;
use App\Exceptions\MainException;

class EditService extends Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @param string $id
     * @param array<mixed> $data
     */
    public function handle($id = 0, $data = [])
    {
        $admin = auth()->user();
        $where = array();
        if(isset($admin->punkt_id))
        {
            $where["punkt_id"] = $admin->punkt_id;
        }
        if(isset($admin->is_test))
        {
            $where["is_test"] = $admin->is_test;
        }
        if(!$this->repository->updateIsAccess($id, $where, $data["is_access"])) 
        {
            throw new MainException("Not updated");
        }
        return new SuccessPayload(__("Success updated"));
    }

}