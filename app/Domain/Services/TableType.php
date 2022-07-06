<?php
namespace App\Domain\Services;

use App\Domain\Payloads\GenericPayload;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

abstract class TableType
{
    abstract public function handle();

    abstract public function action();

    public function getData()
    {
        $row = array();
        if(isset($this->headers)){
            $row["header"] = $this->headers;
        }
        if(isset($this->datas)){
            $row["data"] = $this->datas;
        }
        if(isset($this->actions)){
            $row["action"] = $this->actions;
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
                else 
                {
                    $optimize[$type][] = $key;
                }
            }
        }
        if(isset($row["data"])){
            $data = $row["data"];
            for($i=0; $i<count($data); $i++)
            {
                $data[$i]["action"] = $this->action($data[$i]["id"]);
                foreach ($optimize as $key => $arr)
                {
                    foreach ($arr as $item)
                    {
                        if($key == "reference")
                        {
                            if(isset($data[$i][$item."_id"]) && $data[$i][$item."_name"])
                            {
                                $val = array(
                                    "id" => $data[$i][$item."_id"],
                                    "name" => $data[$i][$item."_name"],
                                );
                                if(isset($data[$i][$item."_color"]))
                                {
                                    $val["color"] = $data[$i][$item."_color"];
                                    unset($data[$i][$item."_color"]);
                                } 
                                $data[$i][$item."_id"] = array($val);
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
                        else  if($key == "datetime")
                        {
                            if($item == "created_at" || $item == "updated_at")
                            {
                                $data[$i][$item] = Carbon::parse((string)$data[$i][$item])->locale(App::currentLocale())->timezone('Asia/Aqtau')->isoFormat('LLLL');
                            }
                        }
                    }
                }
            }
            $row["data"] = $data;
        }
        if(isset($row["action"]))
        {
            foreach(array_keys($row["action"]) as $key)
            {
                $row["action"][$key]["name"] = __($name.".action.".$key.".name");
                $row["action"][$key]["hint"] = __($name.".action.".$key.".hint");
            }
        }
        return $row;
    }
}