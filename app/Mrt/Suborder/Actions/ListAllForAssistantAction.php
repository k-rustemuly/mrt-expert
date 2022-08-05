<?php

namespace App\Mrt\Suborder\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Suborder\Domain\Services\ListAllForAssistantService as Service;
use App\Responders\JsonResponder as Responder;

class ListAllForAssistantAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->start_date, $request->end_date)
        )->respond();
    }
}