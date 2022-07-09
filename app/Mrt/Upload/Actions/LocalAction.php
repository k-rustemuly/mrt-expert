<?php

namespace App\Mrt\Upload\Actions;

use App\Mrt\Upload\Domain\Requests\UploadFormRequest as Request;
use App\Mrt\Upload\Domain\Services\LocalService as Service;
use App\Responders\JsonResponder as Responder;

class LocalAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $request->validated();
        return $this->responder->withResponse(
            $this->service->handle($request->file('file'))
        )->respond();
    }
}