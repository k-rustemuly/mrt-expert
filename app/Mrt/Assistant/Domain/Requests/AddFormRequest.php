<?php

namespace App\Mrt\Assistant\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
            'email' => 'required|email:rfc,dns|unique:App\Mrt\Assistant\Domain\Models\Assistant,email',
        ];
    }

}