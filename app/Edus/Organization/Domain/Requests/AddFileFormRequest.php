<?php

namespace App\Edus\Organization\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFileFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'file' => 'file|mimes:jpg,png,jpeg,pdf|max:10000'
        ];
    }

}