<?php
namespace App\Mrt\Patient\Domain\Repositories;

use App\Domain\Repositories\Repository;
use App\Mrt\Patient\Domain\Models\Login as Model;

class LoginRepository extends Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getByLogin($login)
    {
        return $this->model->where('login', $login)->first();
    }

    public function exists($login, $password)
    {
        return $this->model->where('login', $login)->where('password', $password)->exists();
    }
}