<?php

namespace App\Mrt\Patient\Domain\Requests;

use App\Http\Requests\APIRequest;

class SaveFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'sometimes|required|string|max:255',
            'iin' => 'sometimes|required|string|size:12',
            'phone_number' => 'sometimes|required|string|size:11',
            'email' => 'sometimes|required|email:rfc,dns',
        ];
    }

}