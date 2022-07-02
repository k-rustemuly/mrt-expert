<?php

namespace App\Mrt\Subservice\Domain\Services;

use App\Domain\Services\Service;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository as Repository;
use App\Domain\Payloads\GenericPayload;

class ListService extends Service
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($header = [])
    {
        $data = $this->repository->getAll();
        return new GenericPayload($data);
    }

}