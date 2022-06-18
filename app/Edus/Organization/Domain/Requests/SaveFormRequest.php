<?php

namespace App\Edus\Organization\Domain\Requests;

use App\Http\Requests\APIRequest;

class SaveFormRequest extends APIRequest
{

    public function rules()
    {
        return [
            'name_kk' => 'sometimes|required|string|max:255',
            'name_ru' => 'sometimes|required|string|max:255',
            'full_name_kk' => 'sometimes|required|string|max:255',
            'full_name_ru' => 'sometimes|required|string|max:255',
            'ownership_type_id' => 'sometimes|required|integer|exists:App\Edus\OwnershipType\Domain\Models\OwnershipType,id',
            'departmental_affiliation_id' => 'sometimes|required|integer|exists:App\Edus\DepartmentalAffiliation\Domain\Models\DepartmentalAffiliation,id',
            'legal_form_id' => 'sometimes|required|integer|exists:App\Edus\LegalForm\Domain\Models\LegalForm,id',
            'is_ppp' => 'sometimes|required|boolean',
            'opening_date' => 'sometimes|required|date|before:now',
            'fax' => 'sometimes|required|string|max:50',
            'work_phone' => 'sometimes|required|string|max:50',
            'cellular_telephone' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|max:255|email:rfc,dns',
            'site' => 'sometimes|required|string|max:255|active_url',
            'postcode' => 'sometimes|required|string|max:50',
            'territorial_affiliation_id' => 'sometimes|required|integer|exists:App\Edus\TerritorialAffiliation\Domain\Models\TerritorialAffiliation,id',
            'locality_part_id' => 'sometimes|required|integer|exists:App\Edus\LocalityPart\Domain\Models\LocalityPart,id',
            'locality_name' => 'sometimes|required|string|max:255',
            'house_number' => 'sometimes|required|string|max:50',
            'map_coordinates' => 'sometimes|required|string|max:50',
            'education_type_id' => 'sometimes|required|integer|exists:App\Edus\EducationType\Domain\Models\EducationType,id',
            'direction' => 'sometimes|required|array',
        ];
    }

}