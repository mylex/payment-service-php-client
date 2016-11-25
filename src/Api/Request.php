<?php

namespace PaymentService\Api;

use PaymentService\Client;
use PaymentService\Api\Response;

class Request
{
    private static $httpClient;
    public function __construct($token = null, $endpoint = null)
    {
        $this->_token = $token;
        $this->_endpoint = $endpoint;
    }

    public function request($method, $url, $params = null, $headers = null)
    {
        if (!$params) {
            $params = array();
        }
        if (!$headers) {
            $headers = array();
        }
        list($rbody, $rcode, $rheaders) =
        $this->requestRaw($method, $url, $params, $headers);

        $resp = json_decode($rbody, true);
        $json = $this->interpretResponse($rbody, $rcode, $rheaders);
        $resp = new Response($rbody, $rcode, $rheaders, $json);
        return $resp;
    }

    private function requestRaw($method, $url, $params, $headers)
    {
        $mytoken = Client::$token;
        $version = Client::$version;
        if (!$mytoken) {
            throw new \Exception('No API key provided!');
        }
        $absUrl = $this->_endpoint . '/' . $version . $url;
        if ('get' == strtolower($method) && !empty($params)) {
            $absUrl .= '?' . http_build_query($params);
        }
        $defaultHeaders = $this->defaultHeaders($mytoken);
        $defaultHeaders['Content-Type'] = 'application/json';
        $combinedHeaders = array_merge($defaultHeaders, $headers);
        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $combinedHeaders,
            $params
        );
        return array($rbody, $rcode, $rheaders);
    }

    private static function defaultHeaders($token)
    {
        $defaultHeaders = [
            'Authorization' => 'Bearer ' . $token,
        ];
        return $defaultHeaders;
    }

    private function interpretResponse($rbody, $rcode, $rheaders)
    {
        if ($rcode < 200 || $rcode >= 300) {
            $this->handleApiError($rbody, $rcode, $rheaders);
        }
        try {
            $resp = json_decode($rbody, true);
            if ($rcode == 204) {
                $data = [];
            } else {
                $data = $resp;
            }
        } catch (\Exception $e) {
            $msg = "Invalid response body from API: $rbody "
              . "(HTTP response code was $rcode)";
            throw new Error\Api($msg, $rcode, $rbody);
        }

        return $data;
    }

    public static function setHttpClient($client)
    {
        self::$httpClient = $client;
    }

    private function httpClient()
    {
        if (!self::$httpClient) {
            self::$httpClient = GuzzleClient::instance();
        }
        return self::$httpClient;
    }

    private function handleApiError($rbody, $rcode, $rheaders)
    {
        throw new \Exception("Error Processing API Request", $rcode);

    }
}
