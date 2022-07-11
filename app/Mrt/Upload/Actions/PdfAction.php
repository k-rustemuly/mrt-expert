<?php

namespace App\Mrt\Upload\Actions;

use App\Responders\JsonResponder as Responder;
use App\Domain\Payloads\GenericPayload;

class PdfAction
{

    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            new GenericPayload()
        )->respond();
    }
}