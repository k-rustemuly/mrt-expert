<?php

namespace App\Edus\Departments\Actions;

use App\Edus\Departments\Domain\Requests\EcpAuthFormRequest as Request;
use App\Edus\Departments\Domain\Services\EcpAuthService as Service;
use App\Responders\JsonResponder as Responder;

class EcpAuthAction
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