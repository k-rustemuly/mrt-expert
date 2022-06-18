<?php
namespace App\Helpers;

use Illuminate\Foundation\Http\FormRequest;

abstract class Table extends FormRequest{

    public function getHead()
    {
        $header = $this->getHeader();
        $name = $this->name;
        if(!empty($header)) 
        {
            $keys = array_keys($header);
            foreach($keys as $key)
            {
                $header[$key]["name"] = __($name.".name.".$key);
                $header[$key]["hint"] = __($name.".hint.".$key);
                unset($header[$key]["value"]);
            }
        }
        return $header;
    }
}