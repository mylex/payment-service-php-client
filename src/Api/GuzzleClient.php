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
        } catch (\GuzzleHttp\Exception\GuzzleException $exp) {
            $this->handleGuzzleError($absUrl, $params, $exp);
        }

        return array($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }

    private function handleGuzzleError($url, $param, $exception)
    {
        $resp = $exception->getResponse();
        $rheaders = $exception->getResponse()->getHeaders();
        $rcode = $exception->getResponse()->getStatusCode();
        $msg = $exception->getMessage();
        $rbody = [];
        if ($resp->getBody()) {
            $rbody = json_decode($resp->getBody()->getContents(), true);
        }
        switch ($rcode) {
            case 404:
                // Customize the error message here.
                throw new \PaymentService\Error\InvalidRequest($rcode, $msg, $param);
            case 401:
                throw new \PaymentService\Error\Authentication($rcode, $msg, $param);
            case 402:
                throw new \PaymentService\Error\Card($rcode, $msg, $param);
            case 403:
                throw new \PaymentService\Error\Permission($rcode, $msg, $param);
            case 429:
                throw new \PaymentService\Error\RateLimit($rcode, $msg, $param);
            case 422:
                throw new \PaymentService\Error\InvalidInput($rcode, $msg, $param, $rbody);
            default:
                throw new \PaymentService\Error\Api($rcode, $msg, $param);
        }
    }
}
