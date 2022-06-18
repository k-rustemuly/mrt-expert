<?php
namespace App\Edus\Punkt\Domain\Repositories;

use App\Domain\Repositories\ReferenceRepository;
use App\Edus\Punkt\Domain\Models\Punkt as Model;
use Illuminate\Support\Facades\App;

class PunktRepository extends ReferenceRepository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

    public function getByKato($kato)
    {
        $query = $this->select('*')->where("kato", $kato);
        return $query->first();
    }
}