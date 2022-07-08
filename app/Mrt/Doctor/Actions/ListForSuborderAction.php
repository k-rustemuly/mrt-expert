<?php

namespace App\Mrt\Doctor\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Doctor\Domain\Services\ListForSuborderService as Service;
use App\Responders\JsonResponder as Responder;

class ListForSuborderAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->suborder_id)
        )->respond();
    }
}