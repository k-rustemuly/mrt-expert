<?php

namespace App\Edus\Place\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use App\Domain\Services\Service;
use App\Edus\Place\Domain\Repositories\PlaceRepository as Repository;
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
        $data["author_id"] = $admin->id;
        if(isset($admin->punkt_id) && !isset($data["punkt_id"])) $data["punkt_id"] = $admin->punkt_id;
        if(isset($admin->is_test) && $admin->is_test == 1) $data["is_test"] = $admin->is_test;
        if(!$this->repository->create($data)) throw new MainException("Error when creating new place");
        return new SuccessPayload(__("Success creating new place"));
    }

}