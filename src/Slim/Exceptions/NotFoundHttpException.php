<?php
namespace Ampersand\Slim\Exceptions;

/**
 * Class NotFoundHttpException
 *
 * @package Ampersand\Slim\Exceptions
 */
class NotFoundHttpException extends HttpException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }
}