<?php
namespace App\Edus\EducationType\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\EducationType\Domain\Models\EducationType as Model;
use Illuminate\Support\Facades\App;

class EducationTypeRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}