<?php

namespace App\Mrt\Smsc\Domain\Requests;

use App\Http\Requests\APIRequest;

class WebhookFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'id' => 'sometimes',
            'phone' => 'sometimes',
            'status' => 'sometimes',
            'time' => 'sometimes',
            'err' => 'sometimes',
        ];
    }

}
