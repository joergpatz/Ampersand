<?php
namespace Ampersand\Slim\Exceptions;

/**
 * Class ResourceNotFoundException
 *
 * @package Ampersand\Slim\Exceptions
 */
class ResourceNotFoundException extends NotFoundHttpException
{
    public function __construct($message = "The requested resource was not found.", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}