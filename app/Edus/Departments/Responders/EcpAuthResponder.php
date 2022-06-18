<?php

namespace App\Edus\Departments\Responders;

use App\Responders\Responder;
use App\Responders\ResponderInterface;

class EcpAuthResponder extends Responder implements ResponderInterface
{
    public function respond()
    {
        return response()->json($this->response->getData(), $this->response->getStatus());
    }
}