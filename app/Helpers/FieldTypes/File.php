<?php
namespace App\Helpers\FieldTypes;

class File {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "file",
        "max_file" => 1,
        "max_size_byte" => 1000000000000
    );
}