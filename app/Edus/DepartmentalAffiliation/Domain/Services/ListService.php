<?php

namespace App\Edus\DepartmentalAffiliation\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\DepartmentalAffiliation\Domain\Repositories\DepartmentalAffiliationRepository as Repository;

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