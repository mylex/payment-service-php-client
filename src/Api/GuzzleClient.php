<?php

namespace PaymentService\Api;

use GuzzleHttp\Client;
use PaymentService\Contracts\ClientInterface;

class GuzzleClient implements ClientInterface
{
    private static $instance;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected $defaultOptions;

    public function __construct($defaultOptions = null)
    {
        $this->defaultOptions = $defaultOptions;
    }

    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    public function request($method, $absUrl, $headers, $params)
    {
        $method = strtolower($method);

        $opts = array();

        $rheaders = array();

        $response = null;

        try {
            $http = new Client();
            $response = $http->request(
                $method,
                $absUrl,
                [
                    'headers' => $headers,
                    'body' => json_encode($params)
                ]
            );
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $this->handleGuzzleError($absUrl, $ex->getMessage());
        } catch (\GuzzleHttp\Exception\TransferException $ex) {
            $this->handleGuzzleError($absUrl, $ex->getMessage());
        }
        return array($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }

    private function handleGuzzleError($url, $message)
    {
        $msg = "Unexpected error communicating with Payment Service . \n\n $url";
        $msg .= "\n\n(Network error : $message)";
        throw new \Exception($msg);
    }
}
