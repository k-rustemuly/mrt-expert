<?php
namespace App\Mrt\Service\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Service\Domain\Models\Service as Model;
use Illuminate\Support\Facades\App;

class ServiceRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    public function getById($id)
    {
        $query = $this->select( 'id', 'name_'.$this->language.' as name')->where('id', $id);
        return $query->first()->toArray();
    }
}