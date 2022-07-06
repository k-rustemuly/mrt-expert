<?php

namespace App\Mrt\Suborder\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Order\Domain\Services\PatientListService as Service;
use App\Responders\JsonResponder as Responder;
use App\Domain\Payloads\GenericPayload;

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
            new GenericPayload($request->a)
        )->respond();
    }
}