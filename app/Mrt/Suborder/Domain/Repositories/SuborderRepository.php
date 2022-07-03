<?php
namespace App\Mrt\Suborder\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Mrt\Suborder\Domain\Models\Suborder as Model;
use Illuminate\Support\Facades\App;

class SuborderRepository extends ReferenceRepository
{
    protected $model;

    protected $serviceRepository;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}