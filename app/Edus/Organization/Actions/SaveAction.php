<?php

namespace App\Edus\Organization\Actions;

use App\Edus\Organization\Domain\Requests\SaveFormRequest as Request;
use App\Edus\Organization\Domain\Services\SaveService as Service;
use App\Responders\JsonResponder as Responder;

class SaveAction
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