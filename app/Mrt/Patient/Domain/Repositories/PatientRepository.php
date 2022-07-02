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

    public function getLastGeneratedIin(){
        $search =  $this->model->select('iin')->where('is_iin_generated', true)->orderByDesc('iin')->limit(1);
        if($search) return $search->iin+1;
        return 1;
    }
}