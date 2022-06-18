<?php

namespace App\Edus\EducationOrganizationFileType\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\EducationOrganizationFileType\Domain\Repositories\EducationOrganizationFileTypeRepository as Repository;

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