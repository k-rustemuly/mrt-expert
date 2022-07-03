<?php

namespace App\Mrt\Suborder\Actions;

use App\Mrt\Suborder\Domain\Requests\AddFormRequest as Request;
use App\Mrt\Suborder\Domain\Services\AddService as Service;
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
            $this->service->handle($request->order_id, $request->validated())
        )->respond();
    }
}