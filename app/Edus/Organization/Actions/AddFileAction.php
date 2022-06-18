<?php

namespace App\Edus\Organization\Actions;

use App\Edus\Organization\Domain\Requests\AddFileFormRequest as Request;
use App\Edus\Organization\Domain\Services\AddFileService as Service;
use App\Responders\JsonResponder as Responder;

class AddFileAction
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
            $this->service->handle($request->file_type_id, $request->file('file'))
        )->respond();
    }
}