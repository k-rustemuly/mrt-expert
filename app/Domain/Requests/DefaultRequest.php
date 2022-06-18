<?php

namespace App\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefaultRequest extends FormRequest
{

    public function rules() 
    {
        return array();
    }

}