<?php

namespace App\Mrt\Upload\Actions;

use App\Mrt\Upload\Domain\Requests\AwsUploadFormRequest as Request;
use App\Mrt\Upload\Domain\Services\AwsUploadService as Service;
use App\Responders\JsonResponder as Responder;

class AwsUploadAction
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
            $this->service->handle($request->validated())
        )->respond();
    }
}
