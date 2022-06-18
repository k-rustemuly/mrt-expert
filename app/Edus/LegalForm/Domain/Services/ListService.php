<?php

namespace App\Edus\LegalForm\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\LegalForm\Domain\Repositories\LegalFormRepository as Repository;

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