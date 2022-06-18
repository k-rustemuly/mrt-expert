<?php
namespace App\Edus\AccessStatus\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\AccessStatus\Domain\Models\AccessStatus as Model;
use Illuminate\Support\Facades\App;

class AccessStatusRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}