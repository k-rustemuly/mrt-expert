<?php

namespace App\Mrt\Reception\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
            'email' => 'required|email:rfc,dns|unique:App\Mrt\Reception\Domain\Models\Reception,email',
        ];
    }

}