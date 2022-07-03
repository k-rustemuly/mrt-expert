<?php

namespace App\Mrt\Subservice\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Mrt\Subservice\Domain\Services\BranchListService as Service;
use App\Responders\JsonResponder as Responder;

class BranchListAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->branch_id)
        )->respond();
    }
}