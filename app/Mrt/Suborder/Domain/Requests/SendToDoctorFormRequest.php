<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class SendToDoctorFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'doctors' => 'required|array|min:1',
            'file' => 'required|string',
            'assistant_comment' => 'sometimes|required|string',
        ];
    }

}
