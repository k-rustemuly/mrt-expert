<?php
namespace App\Helpers\FieldTypes;

class Reference {

    /**
     * @var array<mixed>
     */
    public $array = array(
        "type" => "reference",
        "max_select" => 1, //-1 infinit
        "reference_key" => null,
        "reference_name" => null,
        "reference_id" => null
    );

    /**
     * 
     * @param object $model Какой модел соответствует справочнику
     * @param string $identifier Через этот идентификатор будет связывать таблицы
     */
    public function __construct(string $name = "undefined", string $identifier = "id") 
    {
        $this->array["reference_name"] = $name;
        $this->array["reference_id"] = $identifier;
    }
}