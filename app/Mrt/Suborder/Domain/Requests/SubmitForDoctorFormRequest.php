<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class SubmitForDoctorFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'research' => 'sometimes|required|string',
            'conclusion' => 'sometimes|required|string',
        ];
    }

}