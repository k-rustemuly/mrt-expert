<?php

namespace App\Mrt\Suborder\Actions;

use App\Mrt\Suborder\Domain\Requests\RejectForDoctorFormRequest as Request;
use App\Mrt\Suborder\Domain\Services\RejectForDoctorService as Service;
use App\Responders\JsonResponder as Responder;

class RejectForDoctorAction
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