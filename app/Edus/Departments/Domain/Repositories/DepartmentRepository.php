<?php
namespace App\Edus\Departments\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\Departments\Domain\Models\Department as Model;

class DepartmentRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}