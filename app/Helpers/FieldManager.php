<?php
namespace App\Helpers;


abstract class FieldManager {

    /**
     * @var array<mixed>
     */
    protected $etalon = array(
        "type" => "string",
        "on_update" => [
            "is_required" => false,
            "visibility" => "visible" // invisible, disabled
        ],
        "on_create" => [
            "is_required" => false,
            "visibility" => "visible" // invisible, disabled
        ],
        "on_view" => [
            "visibility" => "visible" // invisible, spoiler
        ],
        "name" => null,
        "hint" => null
    );

    public function render(Field $type){   

    }
}