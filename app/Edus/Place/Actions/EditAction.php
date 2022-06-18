<?php

namespace App\Edus\Place\Actions;

use App\Edus\Place\Domain\Requests\EditFormRequest as Request;
use App\Edus\Place\Domain\Services\EditService as Service;
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
            $this->service->handle($request->place_id, $request->validated())
        )->respond();
    }
}