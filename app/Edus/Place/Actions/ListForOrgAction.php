<?php

namespace App\Edus\Place\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Edus\Place\Domain\Services\ListForOrgService as Service;
use App\Responders\JsonResponder as Responder;

class ListForOrgAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}