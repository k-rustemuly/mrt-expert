<?php

namespace App\Edus\Departments\Domain\Requests;

use App\Http\Requests\APIRequest;

class EcpAuthFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'p12' => 'required|string',
            'password' => 'required|string',
        ];
    }

}