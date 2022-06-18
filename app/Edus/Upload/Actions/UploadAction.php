<?php

namespace App\Edus\Upload\Actions;

use App\Edus\Upload\Domain\Requests\UploadFormRequest as Request;
use App\Edus\Upload\Domain\Services\UploadService as Service;
use App\Responders\JsonResponder as Responder;

class UploadAction
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