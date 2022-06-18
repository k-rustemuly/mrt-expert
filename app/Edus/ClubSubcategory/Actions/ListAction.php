<?php

namespace App\Edus\ClubSubcategory\Actions;

use App\Edus\ClubSubcategory\Domain\Services\ListService as Service;
use App\Responders\JsonResponder as Responder;
use Illuminate\Http\Request;

class ListAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse($this->service->handle($request->id))->respond();
    }
}