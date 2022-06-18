<?php

namespace App\Edus\AccessStatus\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\AccessStatus\Domain\Repositories\AccessStatusRepository as Repository;
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
        return new GenericPayload($this->repository->getAll());
    }

}