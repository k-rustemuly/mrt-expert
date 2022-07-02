<?php

namespace App\Mrt\Doctor\Domain\Requests;

use App\Http\Requests\APIRequest;

class SaveFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'sometimes|required|string|max:255',
            'subservices' => 'sometimes|required|array|min:1',
            'is_active' => 'sometimes|required|boolean',
        ];
    }

}