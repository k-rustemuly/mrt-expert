<?php
namespace App\Edus\ClubCategory\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\ClubCategory\Domain\Models\ClubCategory as Model;
use Illuminate\Support\Facades\App;

class ClubCategoryRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}