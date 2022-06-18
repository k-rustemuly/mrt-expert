<?php

namespace App\Edus\Organization\Domain\Requests;

use App\Http\Requests\APIRequest;

class ToCheckFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'p12' => 'required|string',
            'password' => 'required|string',
        ];
    }

}