<?php

namespace App\Edus\LegalForm\Actions;

use App\Edus\LegalForm\Domain\Services\ListService as Service;
use App\Responders\JsonResponder as Responder;

class ListAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->withResponse($this->service->handle())->respond();
    }
}