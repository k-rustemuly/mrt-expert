<?php
namespace App\Helpers\FieldTypes;

class DateTimeRange {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "datetimerange",
        "min_date" => null,
        "max_date" => null,
        "is_picker" => false,
    );
}