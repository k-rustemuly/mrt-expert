<?php
namespace App\Helpers;

class Action{

    /**
     * @var array<mixed>
     */
    public $etalon = array(
        "type" => "primary",
        "name" => null,
        "hint" => "",
        "request_type" => "get",
        "request_url" => "null",
        "after_response" => "refresh",
        "visibility" => "visible" // disabled, visible 
    );

    public static $_instance = null;

    public static function _()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * @param string $request_type get|post|put|delete
     */
    public function requestType($request_type = "get") 
    {
        $this->etalon["request_type"] = $request_type;
        return $this;
    }

    /**
     * @param string $request_url
     */
    public function requestUrl($request_url = "null") 
    {
        $this->etalon["request_url"] = $request_url;
        return $this;
    }

    /**
     * @param string $type Bootstrap front color types primary|success|warning|danger|secondary|info
     */
    public function type($type = "primary") 
    {
        $this->etalon["type"] = $type;
        return $this;
    }

    /**
     * @param string $after_response back|refresh|open_result
     */
    public function afterResponse($after_response = "refresh") 
    {
        $this->etalon["after_response"] = $after_response;
        return $this;
    }

    /**
     * @param string $visibilty visible|disabled
     */
    public function visibility($visibility = "visible") 
    {
        $this->etalon["visibility"] = $visibility;
        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function render()
    {
        self::$_instance = null;
        return $this->etalon;
    }
}