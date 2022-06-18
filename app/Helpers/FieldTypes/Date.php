<?php
namespace App\Helpers\FieldTypes;

class Date {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "date",
        "min_date" => null,
        "max_date" => null,
        "is_picker" => false,
    );
}