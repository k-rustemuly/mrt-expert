<?php

namespace App\Mrt\Smsc\Domain\Services;

use App\Domain\Payloads\SuccessPayload;
use Illuminate\Support\Facades\Log;

class WebhookService
{

    public function handle($data = [])
    {
        $message_id = $data["id"];
        $phone = $data["phone"];
        $status = $data["status"];
        $time = $data["time"];
        $err = $data["err"];
        Log::debug("message_id: ".$message_id);
        Log::debug("phone: ".$phone);
        Log::debug("status: ".$status);
        Log::debug("time: ".$time);
        Log::debug("err: ".$err);
        return new SuccessPayload(__("New admin success added"), $data);
    }

}
