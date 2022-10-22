<?php

namespace App\Mrt\Suborder\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Suborder\Domain\Services\ListForAssistantService as Service;
use App\Responders\JsonResponder as Responder;

class ListForAssistantAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->status_id, $request->search, $request->filter)
        )->respond();
    }
}
