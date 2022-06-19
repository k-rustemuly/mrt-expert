<?php
namespace App\Mrt\Assistant\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Assistant\Domain\Models\Assistant as Model;
use Illuminate\Support\Facades\App;

class AssistantRepository extends Repository
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