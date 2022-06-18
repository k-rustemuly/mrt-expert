<?php

namespace App\Edus\Stat;

use App\Helpers\Url;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ApiFailedException;

class Api 
{
    use Url;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $url;

    public function __construct()
    {
        $settings = config('integration.stat');
        $this->url = $this->getUrl($settings);
        $this->timeout = (int)$settings['timeout'];
    }

    /**
     * Возвращает подробную информацию об организации
     * 
     * @param string $bin БИН или ИИН
     * 
     * @return StatInfo
     */
    public function info(string $bin):StatInfo
    {
        $bin = "070640010665";
        $params = array(
            "bin" => $bin,
            "lang" => "ru"
        );
        $result = $this->request($this->url."/api/juridical/counter/api/", $params);
        return new StatInfo($result);
    }

    /**
     * Запрос в stat.gov.kz
     * 
     * @param array $params
     * 
     * @throws App\Exceptions\ApiFailedException
     * 
     * @return array|mixed
     */
    protected function request(string $url = null, array $query = array()) :array
    {
        $response = Http::timeout($this->timeout)->get($url, $query);

        if($response->successful())  // Определить, имеет ли ответ код состояния >= 200 and < 300...
        {
            $answer = $response->json();
            if(!isset($answer["success"])) {
                throw new ApiFailedException("Stat gov failed");
            }
            if(!$answer["success"])
            {
                throw new ApiFailedException("Company not found");
            }
            return $answer["obj"];
        }
        else if($response->failed()) // Определить, имеет ли ответ код состояния >= 400...
        {
            throw new ApiFailedException("Stat gov failed");
        }
        else if($response->clientError()) // Определить, имеет ли ответ код состояния 400...
        {
            throw new ApiFailedException("Stat gov client error");
        }
        else if($response->serverError()) // Определить, имеет ли ответ код состояния 500...
        {
            throw new ApiFailedException("Stat gov server error");
        }
    }
}