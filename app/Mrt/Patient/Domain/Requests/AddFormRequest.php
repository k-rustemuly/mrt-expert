<?php

namespace App\Mrt\Patient\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'iin' => 'nullable',
            'phone_number' => 'required|string|size:16',
            'email' => 'nullable',
        ];
    }

}