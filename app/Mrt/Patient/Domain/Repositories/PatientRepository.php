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

    public function getByPage($search, $filter)
    {
        $query = $this->model;
        if(is_array($search))
        {
            if(isset($search['iin']))
            {
                $value = $search['iin'];
                $query = $query->where('iin', 'like', "%{$value}%");
            }
            if(isset($search['full_name']))
            {
                $value = $search['full_name'];
                $query = $query->where('full_name', 'like', "%{$value}%");
            }
            if(isset($search['phone_number']))
            {
                $value = $search['phone_number'];
                $value = preg_replace('/[^0-9]/', '', $value);
                $query = $query->where('phone_number', 'like', "%{$value}%");
            }
            if(isset($search['email']))
            {
                $value = $search['email'];
                $query = $query->where('email', 'like', "%{$value}%");
            }
            if(isset($search['birthday']))
            {
                $value = $search['birthday'];
                $query = $query->where('birthday', 'like', "%{$value}%");
            }
        }
        $query = $query->orderByDesc('created_at');
        return $query->jsonPaginate()->toArray();
    }
}
