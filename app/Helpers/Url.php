<?php
namespace App\Helpers;

trait Url {

    public function getUrl(array $params = array()):string
    {
        $url = "";
        $url.= isset($params["scheme"]) ? $params["scheme"] : "http://";
        $url.= isset($params["domain"]) ? $params["domain"] : "google.com";
        $url.= isset($params["port"]) ? ':'.$params["port"] : "";        
        return $url;
    }
}