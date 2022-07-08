<?php

namespace App\Mrt\Suborder\Actions;

use App\Mrt\Suborder\Domain\Requests\UpdateAssistantFormRequest as Request;
use App\Mrt\Suborder\Domain\Services\UpdateAssistantService as Service;
use App\Responders\JsonResponder as Responder;

class UpdateAssistantAction
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