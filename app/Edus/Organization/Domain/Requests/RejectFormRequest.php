<?php

namespace App\Edus\Organization\Domain\Requests;

use App\Http\Requests\APIRequest;

class RejectFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'comment' => 'required|max:255',
        ];
    }

}