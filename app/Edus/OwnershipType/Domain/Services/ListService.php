<?php

namespace App\Edus\OwnershipType\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\OwnershipType\Domain\Repositories\OwnershipTypeRepository as Repository;

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
        $this->reference = $this->repository->getAll(true);
        return $this->getReference();
    }

}