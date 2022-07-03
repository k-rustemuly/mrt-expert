<?php
namespace App\Mrt\Suborder\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Suborder\Domain\Models\Suborder as Model;
use Illuminate\Support\Facades\App;

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

    public function getAllByOrderId($order_id)
    {
        $query = $this->join('rb_suborder_status', $this->model->table.'.status_id', '=', 'rb_suborder_status.id')
        ->select($this->model->table.'.id',
            'rb_suborder_status.name_'.$this->language.' as status_name', 
            'rb_suborder_status.color as status_color',
            $this->model->table.'.appointment_date',
            $this->model->table.'.reception_comment',
            $this->model->table.'.assistant_comment',
            $this->model->table.'.created_at',
            $this->model->table.'.updated_at')
        ->where($this->model->table.'.order_id', $order_id);
        return $query->get()->all();
    }
}