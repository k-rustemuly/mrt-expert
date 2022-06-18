<?php

namespace App\Edus\Organization\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Edus\Organization\Domain\Services\DeleteFileService as Service;
use App\Responders\JsonResponder as Responder;
use App\Domain\Payloads\SuccessPayload;

class DeleteFileAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $this->service->handle($request->file_id);
        return $this->responder->withResponse(
            new SuccessPayload(__("File success deleted"))
        )->respond();
    }
}