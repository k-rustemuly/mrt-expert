<?php
namespace App\Mrt\Smsc\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Smsc\Domain\Models\SmscMessageModel as Model;
use Illuminate\Support\Facades\App;

class SmscMessageRepository extends Repository
{
    protected $model;

    public $language;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->language = App::currentLocale();
    }

}
