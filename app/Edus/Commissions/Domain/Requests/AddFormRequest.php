<?php

namespace App\Edus\Commissions\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'iin' => 'required|digits:12',
            'full_name' => 'required|string|max:255',
        ];
    }

}