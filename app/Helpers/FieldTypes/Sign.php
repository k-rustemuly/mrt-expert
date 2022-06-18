<?php
namespace App\Helpers\FieldTypes;

class Sign {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "sign",
        "choose" => "manual",
    );

    /**
     * 
     * @param string $choose manual|ncalayer
     */
    public function __construct(string $choose = "manual") 
    {
        $this->array["choose"] = $choose;
    }
}