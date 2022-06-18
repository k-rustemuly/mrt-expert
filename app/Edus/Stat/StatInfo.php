<?php

namespace App\Edus\Stat;

class StatInfo
{
    protected $obj = [];

    public function __construct(array $obj)
    {
        $this->obj = $obj;
    }

    public function __get($name)
    {
        return $this->obj[$name];
    }

    public function __isset($name)
    {
        return isset($this->obj[$name]);
    }

}