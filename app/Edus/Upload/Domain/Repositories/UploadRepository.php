<?php
namespace App\Edus\Upload\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\Upload\Domain\Models\Upload as Model;

class UploadRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}