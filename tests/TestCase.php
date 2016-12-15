<?php

use PaymentService\Client;
use PaymentService\Api\Request;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    private $mock;

    protected $baseUrl = 'http://payment-service.dev/api';

    protected function setUp()
    {
        $this->mock = null;
        $this->call = 0;
    }

    protected function mockRequest($method, $path, $params = [], $return = [], $rcode = 200)
    {
        $mock = $this->setUpMockRequest();
        $mock->expects($this->at($this->call++))
             ->method('request')
             ->with(strtolower($method), $this->baseUrl . '/v1' . $path, $this->anything(), $params)
             ->willReturn([json_encode($return), $rcode, []]);
    }

    protected function mockRequestWithException($method, $path, $params = [], $return = [], $rcode = 200)
    {
        $mock = $this->setUpMockRequest();
        $mock->expects($this->at($this->call++))
             ->method('request')
             ->with(strtolower($method), $this->baseUrl . '/v1' . $path, $this->anything(), $params)
             ->will($this->throwException(new Exception));
    }

    private function setUpMockRequest()
    {
        if (!$this->mock) {
            Client::config('myapitoken',$this->baseUrl);
            $this->mock = $this->createMock('\PaymentService\Contracts\ClientInterface');
            Request::setHttpClient($this->mock);
        }
        return $this->mock;
    }

}
