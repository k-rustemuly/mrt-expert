<?php

namespace App\Mrt\Suborder\Actions;

use App\Mrt\Suborder\Domain\Requests\SendToDoctorFormRequest as Request;
use App\Mrt\Suborder\Domain\Services\SendToDoctorService as Service;
use App\Responders\JsonResponder as Responder;

class SendToDoctorAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->suborder_id, $request->validated())
        )->respond();
    }
}