<?php
namespace App\Helpers;

class Block {

    const VERIFIED = "1";

    const NOT_VERIFIED = "2";

    const EDITED = "3";

    const EXTERNAL_FILE_UPLOAD = "external_file_upload";

    const EXTERNAL_FILE_VIEW = "external_file_view";

    const EXTERNAL_TABLE = "external_table";

    /**
     * @var array<mixed>
     */
    public $etalon = array(
        "type" => "block",
        "name" => null,
        "values" => null,
        "action" => null,
        "position" => "default",
        "status" => [
            "id" => 0,
            "name" => null,
        ],
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
     *
     * @param string $status_id
     */
    public function status(string $status_id = "0")
    {
        $this->etalon["status"]["id"] = $status_id;
        return $this;
    }

    /**
     *
     * @param string $name
     */
    public function name(string $name = "")
    {
        $this->etalon["name"] = $name;
        return $this;
    }

    /**
     *
     * @param string $type
     */
    public function type(string $type = "")
    {
        $this->etalon["type"] = $type;
        return $this;
    }

    /**
     *
     * @param string $position
     */
    public function position(string $position = "")
    {
        $this->etalon["position"] = $position;
        return $this;
    }

    /**
     *
     * @param string $key
     * @param string|array|int $value
     */
    public function custom(string $key, $value = null)
    {
        $this->etalon[$key] = $value;
        return $this;
    }

    /**
     *
     * @param array<mixed> $action
     */
    public function action(array $action = array())
    {
        $this->etalon["action"] = $action;
        return $this;
    }

    /**
     *
     * @param array<mixed>
     *
     * @return array<mixed>
     */
    public function values($values = array())
    {
        if(!empty($values))
        {
            $this->etalon["values"] = $values;
        }
        self::$_instance = null;
        return $this->etalon;
    }
}
