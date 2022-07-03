<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'reception_comment' => 'sometimes|required|string',
            'appointment_date' => 'required|date_format:Y-m-d H:i',
            'subservice_id' => 'required|exists:App\Mrt\Subservice\Domain\Models\Subservice,id',
        ];
    }

}