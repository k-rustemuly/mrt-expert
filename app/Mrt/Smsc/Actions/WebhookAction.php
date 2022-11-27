<?php

namespace App\Mrt\Smsc\Actions;

use App\Mrt\Smsc\Domain\Requests\WebhookFormRequest as Request;
use App\Mrt\Smsc\Domain\Services\WebhookService as Service;
use App\Responders\JsonResponder as Responder;

class WebhookAction
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
