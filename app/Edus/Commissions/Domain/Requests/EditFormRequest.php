<?php

namespace App\Edus\Commissions\Domain\Requests;

use App\Http\Requests\APIRequest;

class EditFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'is_access' => 'required|boolean',
        ];
    }

}