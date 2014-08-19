<?php
namespace Ampersand\Slim\Exceptions;

class ConflictHttpException extends HttpException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(409, $message, $code, $previous);
    }
}