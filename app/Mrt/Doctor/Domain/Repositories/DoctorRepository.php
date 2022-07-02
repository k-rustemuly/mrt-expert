<?php
namespace App\Mrt\Doctor\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Doctor\Domain\Models\Doctor as Model;

class DoctorRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}