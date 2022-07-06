<?php
namespace App\Mrt\SuborderStatus\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\SuborderStatus\Domain\Models\SuborderStatus as Model;
use Illuminate\Support\Facades\App;

class SuborderStatusRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}