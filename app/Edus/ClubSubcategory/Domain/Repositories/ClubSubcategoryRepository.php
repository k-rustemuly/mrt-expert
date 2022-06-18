<?php
namespace App\Edus\ClubSubcategory\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\ClubSubcategory\Domain\Models\ClubSubcategory as Model;
use Illuminate\Support\Facades\App;

class ClubSubcategoryRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}