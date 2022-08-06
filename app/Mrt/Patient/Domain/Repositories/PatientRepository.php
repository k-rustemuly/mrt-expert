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
        $search =  $this->model->where('is_iin_generated', 1)->orderByDesc('iin')->first();
        if($search) return $search->iin+1;
        return 1;
    }

    public function getByIin($iin)
    {
        return $this->model->where('iin', $iin)->first();
    }

    public function existsByIin($iin)
    {
        return $this->model->where('iin', $iin)->exists();
    }

    public function getByPage()
    {
        return $this->model->jsonPaginate();
    }
}