<?php
namespace App\Mrt\Upload\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Upload\Domain\Models\Upload as Model;

class UploadRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findByUuid($uuid)
    {
        $upload = $this->model->where("uuid", $uuid)->first();
        return $upload ? $upload->toArray() : [];
    }

    public function getIdByUuid($uuid)
    {
        $upload = $this->findByUuid($uuid);
        if(!empty($upload))
        {
            return $upload["id"];
        }
        return 0;
    }
}