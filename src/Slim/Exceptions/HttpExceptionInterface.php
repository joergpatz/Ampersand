<?php
namespace Ampersand\Slim\Exceptions;

/**
 * Interface HttpExceptionInterface
 *
 * @package Ampersand\Slim\Exceptions
 */
interface HttpExceptionInterface
{
    /**
     * Returns the status code.
     *
     * @return int     An HTTP response status code
     */
    public function getStatusCode();
}