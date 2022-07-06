<?php

namespace App\Mrt\SuborderStatus\Domain\Services;

use App\Domain\Services\Service;
use App\Mrt\SuborderStatus\Domain\Repositories\SuborderStatusRepository as Repository;

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