<?php
namespace App\Mrt\Suborder\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Suborder\Domain\Models\Suborder as Model;
use Illuminate\Support\Facades\App;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus;

class SuborderRepository extends ReferenceRepository
{
    protected $model;

    protected $serviceRepository;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    public function getByBranchId($branch_id, $id)
    {
        $query = $this->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name', 
            'rb_subservice.name_'.$this->language.' as subservice_name', 
            'rb_service.name_'.$this->language.' as service_name', 
            'rb_suborder_status.color as status_color',
            $this->model->table.'.order_id',
            $this->model->table.'.status_id',
            $this->model->table.'.appointment_date',
            $this->model->table.'.reception_comment',
            $this->model->table.'.assistant_comment',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.branch_id', $branch_id)
        ->where($this->model->table.'.id', $id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }

    public function getById($id)
    {
        $query = $this->model->where('id', $id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }

    public function getAllByOrderId($order_id)
    {
        $query = $this->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name', 
            'rb_subservice.name_'.$this->language.' as subservice_name', 
            'rb_service.name_'.$this->language.' as service_name', 
            'rb_suborder_status.color as status_color',
            $this->model->table.'.status_id',
            $this->model->table.'.appointment_date',
            $this->model->table.'.reception_comment',
            $this->model->table.'.assistant_comment',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.order_id', $order_id);
        return $query->get()->all();
    }

    public function deleteByBranchId($branch_id, $order_id, $suborder_id)
    {
        return  $this->where('branch_id', $branch_id)->where('order_id', $order_id)->where('id', $suborder_id)->where('status_id', SuborderStatus::CREATED)->delete();
    }

    public function getAllByStatusId($branch_id, $status_id)
    {
        $query = $this->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select($this->model->table.'.id',
            'rb_subservice.name_'.$this->language.' as subservice_name', 
            'rb_service.name_'.$this->language.' as service_name', 
            $this->model->table.'.status_id',
            $this->model->table.'.appointment_date')
        ->where($this->model->table.'.status_id', $status_id)
        ->where($this->model->table.'.branch_id', $branch_id);
        return $query->get()->all();
    }
}