<?php

namespace App\Mrt\Patient\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Patient\Domain\Services\ListService as Service;
use App\Responders\JsonResponder as Responder;

class ListAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->search, $request->filter)
        )->respond();
    }
}