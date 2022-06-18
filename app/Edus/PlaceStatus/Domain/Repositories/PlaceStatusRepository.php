<?php
namespace App\Edus\PlaceStatus\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\PlaceStatus\Domain\Models\PlaceStatus as Model;
use Illuminate\Support\Facades\App;

class PlaceStatusRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}