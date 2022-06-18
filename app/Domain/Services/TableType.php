<?php
namespace App\Domain\Services;

use App\Domain\Payloads\GenericPayload;

abstract class TableType
{
    abstract public function handle();

    public function getData()
    {
        $row = array();
        if(isset($this->headers)){
            $row["header"] = $this->headers;
        }
        if(isset($this->datas)){
            $row["data"] = $this->datas;
        }
        return new GenericPayload($this->parse($row));
    }

    private function parse(array $row = array())
    {
        $name = $this->name;
        $optimize = array();
        if(isset($row["header"]))
        {
            foreach(array_keys($row["header"]) as $key)
            {
                $row["header"][$key]["name"] = __($name.".header.".$key.".name");
                $row["header"][$key]["hint"] = __($name.".header.".$key.".hint");
                $type = $row["header"][$key]["type"];
                if($type == "reference")
                {
                    $optimize[$type][] = $row["header"][$key]["reference_key"];
                } 
                else if($type == "boolean")
                {
                    $optimize[$type][] = $key;
                }
            }
        }
        if(isset($row["data"])){
            $data = $row["data"];
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
            $row["data"] = $data;
        }
        return $row;
    }
}