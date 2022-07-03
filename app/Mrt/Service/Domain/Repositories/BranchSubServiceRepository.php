<?php
namespace App\Mrt\Service\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Service\Domain\Models\BranchSubService as Model;
use Illuminate\Support\Facades\App;

class BranchSubServiceRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    public function getList($branch_id)
    {
        $query = $this->join('rb_subservice', $this->model->table.'.subservice_id', '=', 'rb_subservice.id')
        ->select('rb_subservice.name_'.$this->language.' as subservice_name', $this->model->table.'.id')
        ->where($this->model->table.'.branch_id', $branch_id);
        return $query->get()->all();
    }

    public function deleteByBranchId($branch_id, $id)
    {
        return $this->model->where('branch_id', $branch_id)->where('id', $id)->delete();
    }
}