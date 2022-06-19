<?php

namespace App\Mrt\Admin\Actions;

use App\Mrt\Admin\Domain\Requests\AddFormRequest as Request;
use App\Mrt\Admin\Domain\Services\AddService as Service;
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
            $this->service->handle($request->branche_id, $request->validated())
        )->respond();
    }
}