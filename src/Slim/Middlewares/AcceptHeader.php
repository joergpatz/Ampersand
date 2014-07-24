<?php

namespace Ampersand\Slim\Middlewares;

/**
 * Class AcceptHeader
 *
 * The Accept request-header field can be used to specify certain media types which are acceptable for the response.
 * @package Ampersand\Slim\Middlewares
 */
class AcceptHeader extends \Slim\Middleware
{
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Get the clients Accept header type
        $acceptType = $app->request->headers->get('Accept');

        $acceptTypeParts = array();
        if ($acceptType) {
            $acceptTypeParts = preg_split('/\s*[;,]\s*/', $acceptType);
        }

        // Set response header according to the client acceptance
        switch(true) {
            case in_array('application/json', $acceptTypeParts):
                $app->response->headers->set('Content-Type', 'application/json');
                break;
            case in_array('text/html', $acceptTypeParts):
                $app->response->headers->set('Content-Type', 'text/html');
                break;
            default:
                $app->response->headers->set('Content-Type', 'text/plain');
        }

        // Run inner middleware and application
        $this->next->call();
    }
}