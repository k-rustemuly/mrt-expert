<?php

namespace App\Edus\PlaceType\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\PlaceType\Domain\Repositories\PlaceTypeRepository as Repository;

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