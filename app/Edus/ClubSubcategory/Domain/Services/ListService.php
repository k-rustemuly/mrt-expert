<?php

namespace App\Edus\ClubSubcategory\Domain\Services;

use App\Domain\Services\Service;
use App\Edus\ClubSubcategory\Domain\Repositories\ClubSubcategoryRepository as Repository;

class ListService extends Service
{

    protected $repository;

    public $reference;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($parent_id = 0)
    {
        $this->reference = $this->repository->getAllByParentId($parent_id);
        return $this->getReference();
    }

}