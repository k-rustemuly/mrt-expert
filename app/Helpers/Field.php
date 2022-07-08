<?php
namespace App\Helpers;

use App\Helpers\FieldTypes\File;
use App\Helpers\FieldTypes\Image;
use App\Helpers\FieldTypes\Reference;
use App\Helpers\FieldTypes\DateTimeRange;

class Field{

    /**
     * @var array<mixed>
     */
    public $etalon = array(
        "type" => "string",
        "on_update" => [
            "is_required" => false,
            "visibility" => "invisible" // invisible, disabled
        ],
        "on_create" => [
            "is_required" => false,
            "visibility" => "invisible" // invisible, disabled
        ],
        "on_view" => [
            "visibility" => "visible" // invisible, spoiler
        ],
        "name" => null,
        "hint" => null,
        "value" => null,
    );

    public $model;

    public static $_instance = null;

    public static function _()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function init($model) 
    {
        $this->model = $model;
        $this->etalon = array_merge($this->etalon, $model->array);
        return $this;
    }

    /**
     * 
     * @param string $visibility visible|invisible|disabled
     * @param bool is_required
     */
    public function onUpdate(string $visibility = "visible", bool $is_required = false) 
    {
        $this->etalon["on_update"]["is_required"] = $is_required;
        $this->etalon["on_update"]["visibility"] = $visibility;
        return $this;
    }

    /**
     * 
     * @param string $visibility visible|invisible|disabled
     * @param bool is_required
     */
    public function onCreate(string $visibility = "visible", bool $is_required = false) 
    {
        $this->etalon["on_create"]["is_required"] = $is_required;
        $this->etalon["on_create"]["visibility"] = $visibility;
        return $this;
    }

    /**
     * 
     * @param string $visibility visible|invisible|spoiler
     */
    public function onView(string $visibility = "visible") 
    {
        $this->etalon["on_view"]["visibility"] = $visibility;
        return $this;
    }

    /**
     * 
     * @param int $length
     */
    public function minLength(int $length = 0)
    {
        $this->etalon["min_length"] = $length;
        return $this;
    }

    /**
     * 
     * @param int $length
     */
    public function maxLength(int $length = 0)
    {
        $this->etalon["max_length"] = $length;
        return $this;
    }

    /**
     * 
     * @param int $number
     */
    public function min(int $number = 0)
    {
        $this->etalon["min"] = $number;
        return $this;
    }
    /**
     * 
     * @param array|string|int $value
     */
    public function value($value = null)
    {
        $this->etalon["value"] = $value;
        return $this;
    }

    /**
     * 
     * @param int $number
     */
    public function max(int $number = 0)
    {
        $this->etalon["max"] = $number;
        return $this;
    }

    /**
     * 
     * @param string $date Y-m-d H:i:s
     */
    public function minDate(?string $date = null)
    {
        $this->etalon["min_date"] = $date;
        return $this;
    }

    /**
     * 
     * @param string $date Y-m-d H:i:s
     */
    public function maxDate(?string $date = null)
    {
        $this->etalon["max_date"] = $date;
        return $this;
    }

    /**
     * 
     * @param bool 
     */
    public function isPicker(bool $picker = false)
    {
        $this->etalon["is_picker"] = $picker;
        return $this;
    }

    /**
     * 
     * @param string $url
     */
    public function url(?string $url = null)
    {
        if($this->model instanceof File || $this->model instanceof Image) $this->etalon["value"]["url"] = $url;
        return $this;
    }

    /**
     * 
     * @param string $preview
     */
    public function preview(?string $preview = null)
    {
        $this->etalon["value"]["preview"] = $preview;
        return $this;
    }

    /**
     * 
     * @param string $name
     */
    public function tagName(?string $name = null)
    {
        $this->etalon["tag_name"] = $name;
        return $this;
    }

    /**
     * 
     * @param string|int $id
     */
    public function tagId($id = "")
    {
        $this->etalon["tag_id"] = $id;
        return $this;
    }

    /**
     * 
     * @param string $key
     */
    public function key(?string $key = null)
    {
        if($this->model instanceof Reference) $this->etalon["reference_key"] = $key;
        return $this;
    }

    /**
     * 
     * @param bool
     */
    public function isFuture(bool $future = false)
    {
        if($this->model instanceof DateTimeRange) $this->etalon["is_future"] = $future;
        return $this;
    }

    /**
     * 
     * @param bool $is_block
     */
    public function render(bool $is_block = false)
    {
        self::$_instance = null;
        if($is_block) return $this->array_slice_keys( $this->etalon, array("type", "name", "value") );
        return $this->etalon;
    }

    /**
     * 
     * @param int $max_file
     */
    public function maxFile(int $max_file = 0)
    {
        $this->etalon["max_file"] = $max_file;
        return $this;
    }

    /**
     * 
     * @param int $max_select
     */
    public function maxSelect(int $max_select = 0)
    {
        $this->etalon["max_select"] = $max_select;
        return $this;
    }

    /**
     * 
     * @param int $max_size_byte
     */
    public function maxSizeByte(int $max_size_byte = 0)
    {
        $this->etalon["max_size_byte"] = $max_size_byte;
        return $this;
    }

    /**
     * 
     * @param string $id 
     */
    public function link(string $id = "")
    {
        $this->etalon["linked_element"] = $id;
        return $this;
    }

    /**
     * 
     * @param string $allow_ext 
     */
    public function allowExt(string $allow_ext = "")
    {
        $this->etalon["allow_ext"] = $allow_ext;
        return $this;
    }

    /**
     * 
     * @param string $reference_url
     */
    public function referenceUrl(?string $reference_url = null)
    {
        if($this->model instanceof Reference) $this->etalon["reference_url"] = $reference_url;
        return $this;
    }

    private function array_slice_keys($array, $keys = null) {
        if ( empty($keys) ) {
            $keys = array_keys($array);
        }
        if ( !is_array($keys) ) {
            $keys = array($keys);
        }
        if ( !is_array($array) ) {
            return array();
        } else {
            return array_intersect_key($array, array_fill_keys($keys, '1'));
        }
    }
}