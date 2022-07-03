<?php

namespace App\Mrt\Service\Actions;

use App\Mrt\Service\Domain\Requests\AddFormRequest as Request;
use App\Mrt\Service\Domain\Services\AddService as Service;
use App\Responders\JsonResponder as Responder;

class AddAction
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