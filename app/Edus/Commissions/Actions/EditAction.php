<?php

namespace App\Edus\Commissions\Actions;

use App\Edus\Commissions\Domain\Requests\EditFormRequest as Request;
use App\Edus\Commissions\Domain\Services\EditService as Service;
use App\Responders\JsonResponder as Responder;

class EditAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->id, $request->validated())
        )->respond();
    }
}