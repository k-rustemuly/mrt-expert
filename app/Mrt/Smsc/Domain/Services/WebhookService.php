<?php

namespace App\Mrt\Smsc\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use Illuminate\Support\Facades\Log;

class WebhookService
{

    public function handle($data = [])
    {
        Log::debug(implode(",", $data));
        return new SuccessPayload(__("New admin success added"), $data);
    }

}
