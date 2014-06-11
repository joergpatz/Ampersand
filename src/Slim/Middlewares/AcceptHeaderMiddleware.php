<?php

namespace Ampersand\Slim\Middlewares;


class AcceptHeaderMiddleware extends \Slim\Middleware
{
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Get Accept Header
        $accept = $app->request->headers->get('Accept');

        // Run inner middleware and application
        $this->next->call();

        // Set Response Header according to the response
        switch($accept) {
            case 'application/json':
            default:
                $app->response->headers->set('Content-Type', 'application/json');
        }
    }
}