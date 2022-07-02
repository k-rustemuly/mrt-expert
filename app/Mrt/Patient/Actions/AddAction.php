<?php

namespace App\Mrt\Patient\Actions;

use App\Mrt\Patient\Domain\Requests\AddFormRequest as Request;
use App\Mrt\Patient\Domain\Services\AddService as Service;
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