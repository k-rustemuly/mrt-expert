<?php

namespace App\Mrt\Assistant\Actions;

use App\Mrt\Assistant\Domain\Requests\SignInFormRequest as Request;
use App\Mrt\Assistant\Domain\Services\SignInService as Service;
use App\Responders\JsonResponder as Responder;

class SignInAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}