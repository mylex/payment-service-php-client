<?php

namespace PaymentService\Error;

class InvalidInput extends Base
{
    function __construct($code, $message, $param = [], $errors=[])
    {
        parent::__construct($code, $message, $param);
        $this->errors = $errors;
    }

}
