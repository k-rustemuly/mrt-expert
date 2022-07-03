<?php

namespace App\Mrt\Service\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'subservice_id' => 'required|integer|exists:App\Mrt\Subservice\Domain\Models\Subservice,id',
        ];
    }

}