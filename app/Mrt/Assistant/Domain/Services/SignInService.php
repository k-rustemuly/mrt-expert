<?php

namespace App\Mrt\Assistant\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use App\Domain\Services\Service;
use App\Mrt\Assistant\Domain\Repositories\AssistantRepository as Repository;
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
        $email = $data["email"];
        $password = $data["password"];
        $user = $this->repository->getByEmail($email);
        if(!$user || !password_verify($password, $user->password)) throw new MainException("Email or password is incorrect");
        if(!$user->is_active) throw new MainException("You account is blocked");

        if (! $token = auth('assistant')->login($user)) {
            throw new MainException("Email or password is incorrect");
        }
        $user->last_visit = date('Y-m-d H:i:s');
        $user->update();
        return new GenericPayload(
            array(
                "user" => [
                    "name" => $user->full_name,
                    "email" => $user->email
                ],
                "token" => $token
            )
        );
    }
}