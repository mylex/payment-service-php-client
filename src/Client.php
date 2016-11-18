<?php

namespace PaymentService;

class Client
{
    public static $token;
    public static $endpoint;
    public static $version = 'v1';
    const ENV_TOKEN = 'PAYMENT_SERVICE_API_TOKEN';
    const ENV_ENDPOINT = 'PAYMENT_SERVICE_API_ENDPOINT';

    public static function config($token, $endpoint)
    {
        self::setEndpoint($endpoint);
        self::setToken($token);
    }

    public static function getEndpoint()
    {
        return self::$endpoint;
    }

    public static function setEndpoint($endpoint)
    {
        self::$endpoint = $endpoint;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function setToken($token)
    {
        self::$token = $token;
    }

    public static function configFromEnv()
    {
        $endpoint = getenv(self::ENV_ENDPOINT);
        $token = getenv(self::ENV_TOKEN);
        if ($endpoint && $token) {
            self::setToken($token);
            self::setEndpoint($endpoint);
        } else {
            throw new \Exception("Environment variable name `".self::ENV_TOKEN."` is not set");
        }
    }

    public static function configFromIni($file)
    {
        if (is_file($file)) {
            $config = parse_ini_file($file);
            if (isset($config[self::ENV_TOKEN]) && !empty($config[self::ENV_TOKEN]) &&
                isset($config[self::ENV_ENDPOINT]) && !empty($config[self::ENV_ENDPOINT])) {
                self::setToken($config[self::ENV_TOKEN]);
                self::setEndpoint($config[self::ENV_ENDPOINT]);
            } else {
                throw new \Exception("Could not read ".self::ENV_TOKEN." value from `".$file."`");
            }
        } else {
            throw new \Exception("Could not read ini file `".$file."`");
        }
    }
}
