<?php

namespace App\Edus\Place\Domain\Requests;

use App\Http\Requests\APIRequest;

class EditFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'club_category_id' => 'sometimes|required|integer|exists:App\Edus\ClubCategory\Domain\Models\ClubCategory,id',
            'club_subcategory_id' => 'sometimes|required|integer|exists:App\Edus\ClubSubcategory\Domain\Models\ClubSubcategory,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'amount' => 'sometimes|required|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'place_type_id' => 'sometimes|required|integer|exists:App\Edus\PlaceType\Domain\Models\PlaceType,id',
            'start_date' => 'sometimes|required|date_format:Y-m-d H:i',
            'end_date' => 'sometimes|required|date|after:start_date'
        ];
    }

}