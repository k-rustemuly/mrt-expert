<?php

namespace App\Mrt\Upload\Domain\Requests;

use App\Http\Requests\APIRequest;

class UploadFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'file' => 'sometimes|required|file',
            'files' => 'sometimes|required|array|file'
        ];
    }

}
