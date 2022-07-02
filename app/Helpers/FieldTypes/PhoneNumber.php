<?php
namespace App\Helpers\FieldTypes;

class PhoneNumber {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "phone_number",
        "mask" => "+7(###)###-##-##",
    );
}