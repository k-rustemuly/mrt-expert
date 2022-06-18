<?php
namespace App\Edus\PlaceType\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\PlaceType\Domain\Models\PlaceType as Model;
use Illuminate\Support\Facades\App;

class PlaceTypeRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}