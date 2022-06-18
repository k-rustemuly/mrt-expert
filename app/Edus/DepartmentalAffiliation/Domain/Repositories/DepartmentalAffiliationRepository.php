<?php
namespace App\Edus\DepartmentalAffiliation\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\DepartmentalAffiliation\Domain\Models\DepartmentalAffiliation as Model;
use Illuminate\Support\Facades\App;

class DepartmentalAffiliationRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}