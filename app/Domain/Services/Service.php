<?php
namespace App\Domain\Services;

use App\Domain\Payloads\GenericPayload;

abstract class Service
{
    abstract public function handle();

    public function getTable()
    {
        $header = $this->header;
        $data = $this->data;
        $raw = array(
            "header" => $header,
            "data" => [],
        );
        if(empty($data)) {
            return new GenericPayload($raw);
        }
        $optimize = array();
        foreach ($header as $key => $value) {
            $type = $value["type"];
            if($type == "reference")
            {
                $optimize[$type][] = $value["reference_key"];
            } else if($type == "boolean")
            {
                $optimize[$type][] = $key;
            }
        }

        for($i=0; $i<count($data); $i++)
        {
            foreach ($optimize as $key => $arr)
            {
                foreach ($arr as $item)
                {
                    if($key == "reference")
                    {
                        if(isset($data[$i][$item."_id"]) && $data[$i][$item."_name"])
                        {
                            $data[$i][$item."_id"] = array(
                                "id" => $data[$i][$item."_id"],
                                "value" => $data[$i][$item."_name"],
                            );
                            if(isset($data[$i][$item."_color"]))
                            {
                                $data[$i][$item."_id"] = array_merge($data[$i][$item."_id"], array("color" => $data[$i][$item."_color"]));
                                unset($data[$i][$item."_color"]);
                            } 
                            // unset($data[$i][$item."_id"]);
                            unset($data[$i][$item."_name"]);
                        }
                    }
                    else if($key == "boolean")
                    {
                        if(isset($data[$i][$item]))
                        {
                            $data[$i][$item] = array(
                                "id" => $data[$i][$item],
                                "value" => __($data[$i][$item] ? "yes" : "no")
                            );
                        }
                    }
                }
            }
        }
        $raw["data"] = $data;
        return new GenericPayload($raw);
    }

    public function getReference()
    {
        return new GenericPayload($this->setChildren());
    }

    private function setChildren($parent_id = 0)
    {
        $data = array();
        $reference = $this->reference;
        if(is_array($reference))
        {
            foreach ($reference as $k => $i)
            {
                if($i["parent_id"] == $parent_id)
                {
                    $children = [];
                    if($i["is_have_child"] == 1)
                    {
                        $children = $this->setChildren($i["id"]);
                    }
                    $data[] = [
                        "id" => $i["id"],
                        "name" => $i["name"],
                        "children" => $children,
                    ];
                    unset($this->reference[$k]);
                }
                
            }
        }
        return $data;
    }
}