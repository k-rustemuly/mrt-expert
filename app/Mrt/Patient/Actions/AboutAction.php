<?php

namespace App\Mrt\Patient\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Patient\Domain\Services\AboutService as Service;
use App\Responders\JsonResponder as Responder;

class AboutAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->patient_id)
        )->respond();
    }
}