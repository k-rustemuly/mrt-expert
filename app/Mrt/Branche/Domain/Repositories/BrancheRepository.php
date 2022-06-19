<?php
namespace App\Mrt\Branche\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Branche\Domain\Models\Branche as Model;
use Illuminate\Support\Facades\App;

class BrancheRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    /**
     * Берем список всех филиалов
     * 
     * @return array<mixed>
     */
    public function getList()
    {
        $query = $this->join('rb_punkt', $this->model->table.'.punkt_id', '=', 'rb_punkt.id')
        ->select($this->model->table.'.*', 
            'rb_punkt.name_'.$this->language.' as punkt_name');
        return $query->get()->all();
    }

    public function getById($id)
    {
        $query = $this->join('rb_punkt', $this->model->table.'.punkt_id', '=', 'rb_punkt.id')
        ->select($this->model->table.'.*', 
            'rb_punkt.name_'.$this->language.' as punkt_name')
            ->where($this->model->table.'.id', $id);
        $result = $query->first();
        return $result ? $result->toArray() : [];
    }
}