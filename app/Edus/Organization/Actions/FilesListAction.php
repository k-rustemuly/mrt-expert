<?php

namespace App\Edus\Organization\Actions;

use App\Domain\Requests\DefaultRequest as Request;
use App\Edus\Organization\Domain\Services\FilesListService as Service;
use App\Responders\JsonResponder as Responder;

class FilesListAction
{

    public function __construct(Responder $responder, Service $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $organization_id = 0;
        if(isset($request->organization_id))
        {
            $organization_id = $request->organization_id;
        }
        else{
            $user = auth('organization')->user();
            if(isset($user->organization_id))
            {
                $organization_id = $user->organization_id;
            }
        }
        return $this->responder->withResponse(
            $this->service->handle($organization_id, $request->file_type_id)
        )->respond();
    }
}