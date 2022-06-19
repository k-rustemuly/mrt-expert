<?php
namespace App\Mrt\Punkt\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Punkt\Domain\Models\Punkt as Model;
use Illuminate\Support\Facades\App;

class PunktRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}