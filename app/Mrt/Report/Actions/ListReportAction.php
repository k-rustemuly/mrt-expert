<?php

namespace App\Mrt\Report\Actions;

use App\Mrt\Report\Domain\Services\ListService as Service;
use App\Responders\JsonResponder as Responder;

class ListReportAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}
