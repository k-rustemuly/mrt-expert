<?php
namespace App\Helpers\FieldTypes;

class Aws {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "aws",
        "upload_url" => null,
        "max_file" => 1,
        "accept" => "*",
        "max_size_byte" => 5000000000
    );

    public function __construct(){
        $this->array["upload_url"] = config("filesystems.disks.s3.upload_url");
    }
}
