<?php
namespace App\Edus\LegalForm\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\LegalForm\Domain\Models\LegalForm as Model;
use Illuminate\Support\Facades\App;

class LegalFormRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}