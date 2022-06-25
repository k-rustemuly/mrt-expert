<?php

namespace App\Mrt\Branch\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'name_kk' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'punkt_id' => 'required|integer|exists:App\Mrt\Punkt\Domain\Models\Punkt,id',
        ];
    }

}