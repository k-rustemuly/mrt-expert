<?php

namespace App\Mrt\Reception\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use App\Domain\Services\Service;
use App\Mrt\Reception\Domain\Repositories\ReceptionRepository as Repository;
use App\Exceptions\UnauthorizedException;

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
        if(!$user || !password_verify($password, $user->password)) throw new UnauthorizedException("Email or password is incorrect");
        if(!$user->is_active) throw new UnauthorizedException("You account is blocked");

        if (! $token = auth('reception')->login($user)) {
            throw new UnauthorizedException("Email or password is incorrect");
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