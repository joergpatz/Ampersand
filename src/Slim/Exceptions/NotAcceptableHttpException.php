<?php
namespace Ampersand\Slim\Exceptions;

class NotAcceptableHttpException extends HttpException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(406, $message, $code, $previous);
    }
}