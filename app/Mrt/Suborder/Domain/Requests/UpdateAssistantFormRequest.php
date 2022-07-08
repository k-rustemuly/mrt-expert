<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class UpdateAssistantFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'assistant_comment' => 'sometimes|required|string',
            'appointment_date' => 'required|date_format:Y-m-d H:i'
        ];
    }

}