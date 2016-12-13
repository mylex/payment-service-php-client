<?php

namespace PaymentService\Error;

use Exception;

abstract class Base extends Exception
{
    protected $errors;
    protected $params;
    public function __construct($code, $message, $params = []) {
        parent::__construct($message, $code);
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function __toString()
    {
        $message = explode("\n", parent::__toString());
        return implode("\n", $message);
    }
}
