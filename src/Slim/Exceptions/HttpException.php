<?php
namespace Ampersand\Slim\Exceptions;

/**
 * Class HttpException
 * Extended RuntimeException for HTTP Status Codes.
 *
 * @package Ampersand\Slim\Exceptions
 */
class HttpException extends \RuntimeException implements HttpExceptionInterface
{
    private $statusCode;

    public function __construct($statusCode, $message = "", $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}