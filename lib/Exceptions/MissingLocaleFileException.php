<?php

namespace Heidelpay\CustomerMessages\Exceptions;

use Exception;

class MissingLocaleFileException extends Exception
{
    protected $message;
    protected $code = 404;
}