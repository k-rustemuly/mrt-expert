<?php
namespace App\Edus\LocalityPart\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\LocalityPart\Domain\Models\LocalityPart as Model;
use Illuminate\Support\Facades\App;

class LocalityPartRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}