<?php

namespace App\Mrt\Patient\Domain\Requests;

use App\Http\Requests\APIRequest;

class ExistFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'iin' => 'required|string|size:12',
        ];
    }

}