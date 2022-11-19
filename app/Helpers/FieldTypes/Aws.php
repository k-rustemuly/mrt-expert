<?php
namespace App\Helpers\FieldTypes;

class Aws {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "aws",
        "max_file" => 1,
        "accept" => "*",
        "max_size_byte" => 5000000000
    );
}
