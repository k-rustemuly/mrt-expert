<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class RejectForDoctorFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'doctor_comment' => 'sometimes|required|string',
        ];
    }

}