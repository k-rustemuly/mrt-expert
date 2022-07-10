<?php

namespace App\Mrt\Patient\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use App\Domain\Services\Service;
use App\Mrt\Patient\Domain\Repositories\LoginRepository as Repository;
use App\Exceptions\MainException;

class SignInService extends Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($data = [])
    {
        $login = $data["login"];
        $password = $data["password"];
        $user = $this->repository->getByLogin($login);
        if(!$user || $password != $user->password) throw new MainException("Login or password is incorrect");
        if($user->to_inactive < date('Y-m-d H:i:s')) throw new MainException("You account is blocked");

        if (! $token = auth('patient')->login($user)) {
            throw new MainException("Login or password is incorrect");
        }
        $user->last_visit = date('Y-m-d H:i:s');
        $user->update();
        return new GenericPayload(
            array(
                "user" => [
                    "name" => $user->full_name,
                    "login" => $user->login
                ],
                "token" => $token
            )
        );
    }
}