<?php

namespace App\Mrt\Suborder\Domain\Requests;

use App\Http\Requests\APIRequest;

class CancelFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'cancel_comment' => 'required|string',
        ];
    }

}
