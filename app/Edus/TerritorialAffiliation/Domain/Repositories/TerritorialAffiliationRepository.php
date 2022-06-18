<?php
namespace App\Edus\TerritorialAffiliation\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\TerritorialAffiliation\Domain\Models\TerritorialAffiliation as Model;
use Illuminate\Support\Facades\App;

class TerritorialAffiliationRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}