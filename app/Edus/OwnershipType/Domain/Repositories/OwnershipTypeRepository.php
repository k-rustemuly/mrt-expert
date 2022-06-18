<?php
namespace App\Edus\OwnershipType\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\OwnershipType\Domain\Models\OwnershipType as Model;
use Illuminate\Support\Facades\App;

class OwnershipTypeRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}