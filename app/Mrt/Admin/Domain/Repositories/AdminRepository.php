<?php
namespace App\Mrt\Admin\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Admin\Domain\Models\Admin as Model;
use Illuminate\Support\Facades\App;

class AdminRepository extends Repository
{
    protected $model;

    private $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    /**
     * Берем список всех админов одного филиала
     * 
     * @return array<mixed>
     */
    public function getList($branche_id)
    {
        $query = $this->select('*')
        ->where('branche_id', $branche_id);
        return $query->get()->all();
    }
}