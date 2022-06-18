<?php
namespace App\Edus\OrganizationAdmin\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Edus\OrganizationAdmin\Domain\Models\Admin as Model;

class AdminRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}