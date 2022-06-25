<?php
namespace App\Mrt\Reception\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Reception\Domain\Models\Reception as Model;
use Illuminate\Support\Facades\App;

class ReceptionRepository extends Repository
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