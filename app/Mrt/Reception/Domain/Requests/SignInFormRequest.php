<?php

namespace App\Mrt\Reception\Domain\Requests;

use App\Http\Requests\APIRequest;

class SignInFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string',
        ];
    }

}