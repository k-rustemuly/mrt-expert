<?php

namespace App\Edus\LocalityPart\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\LocalityPart\Domain\Repositories\LocalityPartRepository as Repository;

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