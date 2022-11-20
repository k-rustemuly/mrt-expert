<?php

namespace App\Mrt\Upload\Domain\Requests;

use App\Http\Requests\APIRequest;

class AwsUploadFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'extension' => 'required|string',
            'name' => 'required|string',
            'path' => 'required|string',
            'uuid' => 'required|string'
        ];
    }

}
