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
    public function getList($branch_id)
    {
        $query = $this->select('*')
        ->where('branch_id', $branch_id);
        return $query->get()->all();
    }
}