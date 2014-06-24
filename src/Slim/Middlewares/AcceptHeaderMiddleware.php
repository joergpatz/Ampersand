<?php

namespace Ampersand\Slim\Middlewares;

/**
 * Class AcceptHeaderMiddleware
 *
 * The Accept request-header field can be used to specify certain media types which are acceptable for the response.
 * @package Ampersand\Slim\Middlewares
 */
class AcceptHeaderMiddleware extends \Slim\Middleware
{
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Get the clients Accept header type
        $acceptType = $app->request->headers->get('Accept');

        if ($acceptType) {
            $acceptTypeParts = preg_split('/\s*[;,]\s*/', $acceptType);
            $acceptType = strtolower($acceptTypeParts[0]);
        }

        // Set response header according to the client acceptance
        switch($acceptType) {
            case 'application/json':
            default:
                //TODO: send API-Problem 406 Not Acceptable
                $app->response->headers->set('Content-Type', 'application/json');
        }

        // Run inner middleware and application
        $this->next->call();
    }
}