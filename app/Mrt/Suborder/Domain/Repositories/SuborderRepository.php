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
        ->leftJoin('upload', $this->model->table.'.file', '=', 'upload.id')
        ->leftJoin('upload as conclusion', $this->model->table.'.conclusion_file_id', '=', 'conclusion.id')

        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name',
            'rb_suborder_status.color as status_color',
            $this->model->table.'.order_id',
            $this->model->table.'.is_kmis',
            $this->model->table.'.status_id',
            $this->model->table.'.appointment_date',
            $this->model->table.'.reception_comment',
            $this->model->table.'.sender',
            $this->model->table.'.assistant_comment',
            $this->model->table.'.doctor_comment',
            $this->model->table.'.doctors',
            'upload.id as file_id',
            'upload.uuid as file_uuid',
            'upload.name as file_name',
            'upload.url as file_url',
            'conclusion.name as conclusion_file_name',
            'conclusion.url as conclusion_file_url',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.branch_id', $branch_id)
        ->where($this->model->table.'.id', $id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }

    public function getAllByDoctorId($doctor_id, $id)
    {
        $query = $this->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->leftJoin('upload', $this->model->table.'.file', '=', 'upload.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name',
            'rb_suborder_status.color as status_color',
            $this->model->table.'.order_id',
            $this->model->table.'.status_id',
            $this->model->table.'.branch_id',
            $this->model->table.'.reception_comment',
            $this->model->table.'.assistant_comment',
            $this->model->table.'.appointment_date',
            $this->model->table.'.doctor_comment',
            $this->model->table.'.doctors',
            'upload.id as file_id',
            'upload.uuid as file_uuid',
            'upload.name as file_name',
            'upload.url as file_url',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.doctors', 'like' ,"%@".$doctor_id."@%")
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
        ->leftJoin('upload', $this->model->table.'.conclusion_file_id', '=', 'upload.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name',
            'upload.name as file_name',
            'upload.url as file_url',
            'rb_suborder_status.color as status_color',
            $this->model->table.'.status_id',
            $this->model->table.'.branch_id',
            $this->model->table.'.is_kmis',
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

    public function getAllByStatusId($branch_id, $status_id, $search = array(), $filter = array())
    {
        $query = $this->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->join('orders', $this->model->table.'.order_id', '=', 'orders.id')
        ->join('patient', 'orders.patient_id', '=', 'patient.id')
        ->select($this->model->table.'.id',
            'patient.full_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name',
            $this->model->table.'.status_id',
            $this->model->table.'.appointment_date')
        ->where($this->model->table.'.branch_id', $branch_id);
        if($status_id > 0)
        {
            $query = $query->where($this->model->table.'.status_id', $status_id);
        }
        if(is_array($search))
        {
            if(isset($search['full_name']))
            {
                $value = $search['full_name'];
                $query = $query->where('patient.full_name', 'like', "%{$value}%");
            }
        }
        $query = $query->orderByDesc($this->model->table.'.created_at');
        return $query->jsonPaginate()->toArray();
    }

    public function getAllByDateRange($branch_id, $start_date, $end_date)
    {
        $query = $this->join('orders', $this->model->table.'.order_id', '=', 'orders.id')
        ->join('patient', 'orders.patient_id', '=', 'patient.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->select($this->model->table.'.id',
            'patient.full_name',
            'rb_service.name_'.$this->language.' as service_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            $this->model->table.'.status_id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_suborder_status.color as status_color',
            $this->model->table.'.appointment_date')
        ->where($this->model->table.'.appointment_date', '>=', $start_date." 00:00:00")
        ->where($this->model->table.'.appointment_date', '<=', $end_date." 23:59:59")
        ->where($this->model->table.'.branch_id', $branch_id);
        return $query->get()->all();
    }

    public function getAllByDoctorIdAndStatusId($doctor_id, $status_id)
    {
        $query = $this->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->join('orders', $this->model->table.'.order_id', '=', 'orders.id')
        ->join('patient', 'orders.patient_id', '=', 'patient.id')
        ->select($this->model->table.'.id',
            $this->model->table.'.appointment_date',
            'patient.full_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name')
        ->where($this->model->table.'.status_id', $status_id)
        ->where($this->model->table.'.doctors', 'like' ,"%@".$doctor_id."@%");
        return $query->get()->all();
    }

    public function updateByBranchId($branch_id, $id, array $attributes)
    {
        return $this->where(["id" => $id])->where(["branch_id" => $branch_id])->update($attributes);
    }

    public function revoke($branch_id, $id, array $attributes)
    {
        return $this->where(["id" => $id])->where(["branch_id" => $branch_id])->where("status_id", "!=", SuborderStatus::COMPLETED)->update($attributes);
    }

    public function acceptByDoctor($doctor_id, $suborder_id)
    {
        return  $this->where('doctors', 'like', "%@".$doctor_id."@%")->where('id', $suborder_id)->where('status_id', SuborderStatus::WAITING)->update(["status_id" => SuborderStatus::UNDER_TREATMENT, "doctors" => "@".$doctor_id."@"]);
    }

    public function rejectByDoctor($doctor_id, $suborder_id, $comment = null)
    {
        return  $this->where('doctors', 'like', "@".$doctor_id."@")->where('id', $suborder_id)->where('status_id', SuborderStatus::UNDER_TREATMENT)->update(["status_id" => SuborderStatus::REJECTED, "doctor_comment" => $comment]);
    }

    public function submitByDoctor($doctor_id, $suborder_id, $data)
    {
        return  $this->where('doctors', 'like', "%@".$doctor_id."@%")
                ->where('id', $suborder_id)
                ->where('status_id', SuborderStatus::UNDER_TREATMENT)
                ->update($data);
    }

    public function getAllByOrderIdPatient($order_id)
    {
        $query = $this->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->leftJoin('upload', $this->model->table.'.conclusion_file_id', '=', 'upload.id')
        ->join('rb_service', 'rb_subservice.service_id', '=', 'rb_service.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name',
            'rb_subservice.name_'.$this->language.' as subservice_name',
            'rb_service.name_'.$this->language.' as service_name',
            'upload.name as file_name',
            'upload.url as file_url',
            'rb_suborder_status.color as status_color',
            $this->model->table.'.appointment_date')
        ->where($this->model->table.'.order_id', $order_id);
        return $query->get()->all();
    }

    public function updateConclusion($id, $upload_id)
    {
        return $this->where(["id" => $id])->update(["conclusion_file_id" => $upload_id]);
    }

    public function getAllOtherSubordersOrderId($order_id, $suborder_id)
    {
        $query = $this->where('order_id', $order_id)->where('id', '!=', $suborder_id);
        return $query->get()->all();
    }
}
