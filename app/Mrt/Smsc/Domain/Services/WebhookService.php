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
        Log::error("message_id: ".$message_id);
        Log::error("phone: ".$phone);
        Log::error("status: ".$status);
        Log::error("time: ".$time);
        Log::error("err: ".$err);
        return new SuccessPayload(__("New admin success added"), $data);
    }

}
