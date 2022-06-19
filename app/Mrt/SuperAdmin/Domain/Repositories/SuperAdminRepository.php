<?php
namespace App\Mrt\SuperAdmin\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\SuperAdmin\Domain\Models\SuperAdmin as Model;

class SuperAdminRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}