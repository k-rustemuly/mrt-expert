<?php

namespace App\Edus\Place\Domain\Requests;

use App\Http\Requests\APIRequest;

class AddFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'club_category_id' => 'required|integer|exists:App\Edus\ClubCategory\Domain\Models\ClubCategory,id',
            'club_subcategory_id' => 'required|integer|exists:App\Edus\ClubSubcategory\Domain\Models\ClubSubcategory,id',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'place_type_id' => 'required|integer|exists:App\Edus\PlaceType\Domain\Models\PlaceType,id',
            'start_date' => 'required|date_format:Y-m-d H:i',
            'end_date' => 'required|date|after:start_date'
        ];
    }

}