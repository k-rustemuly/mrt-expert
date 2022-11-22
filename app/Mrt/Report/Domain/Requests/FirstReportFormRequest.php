<?php

namespace App\Mrt\Report\Domain\Requests;

use App\Http\Requests\APIRequest;

class FirstReportFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d',
        ];
    }

}
