<?php
namespace App\Domain\Services;

use App\Domain\Payloads\GenericPayload;

abstract class BlockType
{
    abstract public function handle();

    public function getData()
    {
        $row = array();
        if(isset($this->blocks))
        {
            $row["block"] = $this->blocks;
        }
        if(isset($this->actions))
        {
            $row["action"] = $this->actions;
        }
        if(isset($this->headers)){
            $row["header"] = $this->headers;
        }
        if(isset($this->datas)){
            $row["data"] = $this->datas;
        }
        if(isset($this->title)){
            $row["title"] = $this->title;
        }
        return new GenericPayload($this->parse($row));
    }

    private function parse(array $row = array())
    {
        $name = $this->name;
        if(isset($row["block"]))
        {
            foreach(array_keys($row["block"]) as $key)
            {
                if(!isset($row["block"][$key]["name"]) || !$row["block"][$key]["name"])
                    $row["block"][$key]["name"] = __($name.".block.".$key.".name");
                if(is_array($row["block"][$key]["values"]))
                {
                    foreach(array_keys($row["block"][$key]["values"]) as $item)
                    {
                        if(!isset($row["block"][$key]["values"][$item]["visibility"]))
                        {
                            $row["block"][$key]["values"][$item]["visibility"] = "visible";
                        }
                        if(!isset($row["block"][$key]["values"][$item]["type"]))
                        {
                            $row["block"][$key]["values"][$item]["type"] = "string";
                        }
                        if(!isset($row["block"][$key]["values"][$item]["name"]) || !$row["block"][$key]["values"][$item]["name"])
                            $row["block"][$key]["values"][$item]["name"] = __($name.".block.values.".$item.".name");
                    }
                }
                if(is_array($row["block"][$key]["action"]))
                {
                    foreach(array_keys($row["block"][$key]["action"]) as $action_key)
                    {
                        if(!$row["block"][$key]["action"][$action_key]["name"])
                            $row["block"][$key]["action"][$action_key]["name"] = __($name.".action.".$action_key.".name");
                        if(!$row["block"][$key]["action"][$action_key]["hint"])
                            $row["block"][$key]["action"][$action_key]["hint"] = __($name.".action.".$action_key.".hint");
                    }
                }
                // if(is_array($row["block"][$key]["status"]))
                // {
                //     $status = $row["block"][$key]["status"]["id"];
                //     if($status != 0 )
                //     {
                //         if(!$row["block"][$key]["action"][$action_key]["name"])
                //         $row["block"][$key]["status"]["name"] = __($name.".status.".$status);
                //     }
                // }
            }
        }
        if(isset($row["action"]))
        {
            foreach(array_keys($row["action"]) as $key)
            {
                if(!$row["action"][$key]["name"])
                    $row["action"][$key]["name"] = __($name.".action.".$key.".name");
                if(!$row["action"][$key]["hint"])
                    $row["action"][$key]["hint"] = __($name.".action.".$key.".hint");
            }
        }
        if(isset($row["header"]))
        {
            $data = null;
            if(isset($row["data"]))
            {
                $data = $row["data"];
                unset($row["data"]);
            }
            foreach($row["header"] as $action => $fields)
            {
                foreach($fields as $key => $settings)
                {
                    if(!$row["header"][$action][$key]["name"])
                        $row["header"][$action][$key]["name"] = __($name.".header.".$key.".name");
                    if(!$row["header"][$action][$key]["hint"])
                        $row["header"][$action][$key]["hint"] = __($name.".header.".$key.".hint");
                    if($data)
                    {
                        $type = $settings["type"];
                        if($type == "reference")
                        {
                            $reference_key = $settings["reference_key"];
                            if(isset($data[$reference_key."_id"]) && $data[$reference_key."_name"])
                            {
                                $row["header"][$action][$key]["value"] = [
                                    "id" => $data[$reference_key."_id"],
                                    "value" => $data[$reference_key."_name"]
                                ];
                                if(isset($data[$reference_key."_color"]))
                                {
                                    $row["header"][$action][$key]["value"] = array_merge($row["header"][$action][$key]["value"], ["color" => $data[$reference_key."_color"]]);
                                }
                            }
                        }
                        else if($type == "boolean")
                        {
                            if(isset($data[$key]) && !$row["header"][$action][$key]["value"])
                            {
                                $row["header"][$action][$key]["value"] = [
                                    "id" => $data[$key],
                                    "value" => __($data[$key] ? "yes" : "no")
                                ];
                            }
                        }
                        else if($type == "datetime")
                        {
                            if(isset($data[$key]) && !$row["header"][$action][$key]["value"])
                            {
                                $row["header"][$action][$key]["value"] = date("Y-m-d H:i", strtotime($data[$key]));
                            }
                        }
                        else
                        {
                            if(isset($data[$key]) && !$row["header"][$action][$key]["value"])
                            {
                                $row["header"][$action][$key]["value"] = $data[$key];
                            }
                        }
                    }
                }
            }

        }
        return $row;
    }
}
