<?php

namespace App\Mrt\Branch\Domain\Requests;

use App\Http\Requests\APIRequest;

class SaveFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'name_kk' => 'sometimes|required|string|max:255',
            'name_ru' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|required|boolean',
        ];
    }

}