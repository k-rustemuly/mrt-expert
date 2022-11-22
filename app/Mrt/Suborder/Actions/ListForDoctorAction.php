<?php

namespace App\Mrt\Suborder\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Suborder\Domain\Services\ListForDoctorService as Service;
use App\Responders\JsonResponder as Responder;

class ListForDoctorAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $status_id = isset($request->status_id) ? $request->status_id : 0;
        $filter = [];
        if(isset($request->filter)){
            $filter = $request->filter;
        }
        return $this->responder->withResponse(
            $this->service->handle($status_id, $filter)
        )->respond();
    }
}
