<?php
namespace App\Mrt\Patient\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Patient\Domain\Models\Patient as Model;

class PatientRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        $result = $this->model->find($id);
        return $result ? $result->toArray() : [];
    }
}