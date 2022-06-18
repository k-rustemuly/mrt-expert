<?php

namespace App\Edus\Commissions\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Commissions\Domain\Repositories\CommissionRepository as Repository;
use App\Exceptions\MainException;

class AddService extends Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $admin = auth()->user();
        $data["punkt_id"] = $admin->punkt_id;
        $data["bin"] = $admin->bin;
        if(isset($admin->is_test) && $admin->is_test == 1) $data["is_test"] = $admin->is_test;
        if(!$this->repository->isOnceAccessed($admin->punkt_id, $admin->is_test)) throw new MainException("Once accessed commission error");
        if(!$this->repository->create($data)) throw new MainException("Error when creating new commission member");
        return new SuccessPayload(__("Success creating new commission member"));
    }

}