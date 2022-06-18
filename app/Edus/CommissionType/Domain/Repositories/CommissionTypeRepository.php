<?php
namespace App\Edus\CommissionType\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\CommissionType\Domain\Models\CommissionType as Model;
use Illuminate\Support\Facades\App;

class CommissionTypeRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}