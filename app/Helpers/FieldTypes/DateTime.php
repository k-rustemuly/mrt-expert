<?php
namespace App\Helpers\FieldTypes;

class DateTime {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "datetime",
        "min_date" => null,
        "max_date" => null,
        "is_picker" => false,
    );
}