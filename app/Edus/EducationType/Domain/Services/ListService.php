<?php

namespace App\Edus\EducationType\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\EducationType\Domain\Repositories\EducationTypeRepository as Repository;

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