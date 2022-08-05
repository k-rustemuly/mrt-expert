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
        ->join('patient_login', $this->model->table.'.patient_login_id', '=', 'patient_login.id')
        ->select($this->model->table.'.id',
            'rb_order_status.name_'.$this->language.' as status_name', 
            'rb_order_status.color as status_color',
            'patient.id as patient_id',
            'patient.iin',
            'patient.birthday',
            'patient.full_name as patient_name',
            'patient.email',
            'patient.phone_number',
            'reception.full_name as reception_name',
            'patient_login.login',
            'patient_login.password',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.id', $id);
        $result =  $query->first();
        return $result ? $result->toArray() : [];
    }

    public function getAllByPatientId($branch_id, $patient_id)
    {
        $query = $this->join('suborders', $this->model->table.'.id', '=', 'suborders.order_id')
        ->join('rb_suborder_status', 'suborders.status_id', '=', 'rb_suborder_status.id')
        ->join('rb_subservice', 'suborders.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select(
            $this->model->table.'.id',
            'rb_suborder_status.id as status_id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name', 
            'rb_suborder_status.color as status_color',
            'suborders.appointment_date',
            'suborders.created_at')
        ->where($this->model->table.'.patient_id', $patient_id)
        ->where($this->model->table.'.branch_id', $branch_id)
        ->orderByDesc($this->model->table.'.created_at');
        return $query->get()->all();
    }

    public function getByBranchId($branch_id)
    {
        $query = $this->join('rb_order_status', $this->model->table.'.status_id', '=', 'rb_order_status.id')
        ->join('patient', $this->model->table.'.patient_id', '=', 'patient.id')
        ->join('reception', $this->model->table.'.reception_id', '=', 'reception.id')
        ->select($this->model->table.'.id',
            'rb_order_status.name_'.$this->language.' as status_name', 
            'rb_order_status.color as status_color',
            'patient.full_name as patient_name',
            'reception.full_name as reception_name',
            $this->model->table.'.status_id',
            $this->model->table.'.created_at')
        ->where($this->model->table.'.branch_id', $branch_id)
        ->orderByDesc($this->model->table.'.created_at');
        return $query->get()->all();
    }

    public function getByLoginId($patient_login_id)
    {
        $query = $this->join('rb_order_status', $this->model->table.'.status_id', '=', 'rb_order_status.id')
        ->join('patient', $this->model->table.'.patient_id', '=', 'patient.id')
        ->select($this->model->table.'.id',
            'rb_order_status.name_'.$this->language.' as status_name', 
            'rb_order_status.color as status_color',
            'patient.iin',
            'patient.full_name as patient_name',
            $this->model->table.'.created_at')
        ->where($this->model->table.'.patient_login_id', $patient_login_id);
        $result =  $query->first();
        return $result ? $result->toArray() : [];
    }

    public function getAuthById($id)
    {
        $query = $this->join('patient', $this->model->table.'.patient_id', '=', 'patient.id')
        ->join('patient_login', $this->model->table.'.patient_login_id', '=', 'patient_login.id')
        ->select($this->model->table.'.id',
            'patient.phone_number',
            'patient_login.login',
            'patient_login.password')
        ->where($this->model->table.'.id', $id);
        $result =  $query->first();
        return $result ? $result->toArray() : [];
    }
}