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

    public function getById($id)
    {
        $result = $this->model->find($id);
        return $result ? $result->toArray() : [];
    }

    public function getAllBySubserviceId($subservice_id)
    {
        return $this->model->where("subservices", "like", "%@".$subservice_id."@%")->where("is_active", 1)->get()->all();
    }
}