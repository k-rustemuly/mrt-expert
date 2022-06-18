<?php

namespace App\Edus\Pki;

use App\Helpers\Url;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ApiFailedException;

class Api 
{
    use Url;

    /**
     * @var string
     */
    protected $version;

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
        $settings = config('integration.pki');
        $this->url = $this->getUrl($settings);
        $this->version = $settings['version'];
        $this->timeout = (int)$settings['timeout'];
    }

    /**
     * Возвращает подробную информацию о ключе P12
     * 
     * @param string $p12 Закодированный файл c ключом p12, в формате Base64
     * @param string $password Пароль для ключа
     * 
     * @return CertificateInfo
     */
    public function pkcs(string $p12, string $password):CertificateInfo
    {
        $params = array(
            "p12" => $p12,
            "password" => $password,
            "verifyOcsp" => true,
            "verifyCrl" => false,
        );
        $result = $this->request("PKCS12.info", $params);
        return new CertificateInfo($result);
    }

    /**
     * Запрос в пки
     * 
     * @param string $method
     * @param array $params
     * 
     * @throws App\Exceptions\ApiFailedException
     * 
     * @return array|mixed
     */
    protected function request(string $method, array $params = array()) :array
    {
        $json = array(
            "version" => $this->version,
            "method" => $method,
            "params" => $params
        );

        $response = Http::timeout($this->timeout)
        ->withHeaders([
            'Content-Type' => 'application/json'
        ])
        ->post($this->url, $json);

        if($response->successful())  // Определить, имеет ли ответ код состояния >= 200 and < 300...
        {
            //throw new ApiFailedException('Invalid response given: ' . var_export($response->json(), true));
            $answer = $response->json();
            if(!isset($answer["result"])) {
                throw new ApiFailedException("Pki failed");
            }
            return $answer["result"];
        }
        else if($response->failed()) // Определить, имеет ли ответ код состояния >= 400...
        {
            throw new ApiFailedException("Pki failed");
        }
        else if($response->clientError()) // Определить, имеет ли ответ код состояния 400...
        {
            throw new ApiFailedException("Pki client error");
        }
        else if($response->serverError()) // Определить, имеет ли ответ код состояния 500...
        {
            throw new ApiFailedException("Pki server error");
        }
    }
}