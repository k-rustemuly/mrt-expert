<?php

namespace App\Mrt\Report\Actions;

use App\Mrt\Report\Domain\Requests\FirstReportFormRequest as Request;
use App\Mrt\Report\Domain\Services\FirstReportService as Service;
use App\Responders\JsonResponder as Responder;

class FirstReportAction
{
    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->service->handle($request->validated());
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
