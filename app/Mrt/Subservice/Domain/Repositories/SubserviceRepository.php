<?php
namespace App\Mrt\Subservice\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Subservice\Domain\Models\Subservice as Model;
use Illuminate\Support\Facades\App;

class SubserviceRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}