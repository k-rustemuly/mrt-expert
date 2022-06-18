<?php
namespace App\Edus\EducationOrganizationFileType\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\EducationOrganizationFileType\Domain\Models\EducationOrganizationFileType as Model;
use Illuminate\Support\Facades\App;

class EducationOrganizationFileTypeRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }
}