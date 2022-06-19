<?php

namespace App\Mrt\Reception\Domain\Requests;

use App\Http\Requests\APIRequest;

class SaveFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|required|boolean',
        ];
    }

}