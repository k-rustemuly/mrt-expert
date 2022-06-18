<?php

namespace App\Edus\Organization\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Edus\Organization\Domain\Services\AcceptService as Service;
use App\Responders\JsonResponder as Responder;

class AcceptAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->organization_id)
        )->respond();
    }
}