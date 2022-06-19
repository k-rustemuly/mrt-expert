<?php

namespace App\Mrt\Punkt\Domain\Services;

use App\Domain\Services\Service;
use App\Mrt\Punkt\Domain\Repositories\PunktRepository as Repository;

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