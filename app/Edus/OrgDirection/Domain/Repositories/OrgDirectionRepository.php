<?php
namespace App\Edus\OrgDirection\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\OrgDirection\Domain\Models\OrgDirection as Model;
use Illuminate\Support\Facades\App;

class OrgDirectionRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}