<?php

namespace App\Mrt\Order\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Order\Domain\Services\ListForAssistantService as Service;
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
            $this->service->handle()
        )->respond();
    }
}