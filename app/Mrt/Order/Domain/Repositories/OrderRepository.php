<?php
namespace App\Mrt\Order\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Order\Domain\Models\Order as Model;
use Illuminate\Support\Facades\App;

class OrderRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    public function getById($id)
    {
        $query = $this->join('rb_order_status', $this->model->table.'.status_id', '=', 'rb_order_status.id')
        ->join('patient', $this->model->table.'.patient_id', '=', 'patient.id')
        ->join('reception', $this->model->table.'.reception_id', '=', 'reception.id')
        ->select($this->model->table.'.id',
            'rb_order_status.name_'.$this->language.' as status_name', 
            'rb_order_status.color as status_color',
            'patient.id as patient_id',
            'patient.iin',
            'patient.full_name as patient_name',
            'patient.email',
            'patient.phone_number',
            'reception.full_name as reception_name',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.id', $id);
        $result =  $query->first();
        return $result ? $result->toArray() : [];
    }
}