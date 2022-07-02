<?php

namespace App\Mrt\Subservice\Domain\Services;

use App\Domain\Services\Service;
use App\Mrt\Subservice\Domain\Repositories\SubserviceRepository as Repository;

class ListService extends Service
{

    protected $repository;

    public $reference;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($header = [])
    {
        $this->reference = $this->repository->getAll();
        return $this->getReference();
    }

}