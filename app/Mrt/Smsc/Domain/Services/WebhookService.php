<?php

namespace App\Mrt\Smsc\Domain\Services;

use App\Domain\Payloads\SuccessPayload;

class WebhookService
{

    public function handle($data = [])
    {
        return new SuccessPayload(__("New admin success added"), $data);
    }

}
