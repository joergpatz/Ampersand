<?php

namespace Ampersand\Slim\Middlewares;

/**
 * Class ApiError
 *
 * deals with api errors and exceptions
 * @package Ampersand\Slim\Middlewares
 */
class ApiError extends \Slim\Middleware
{
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        if ($app->request->headers->get('Content-Type') === 'application/json') {
            // Switch to custom error handler by disable debug
            $app->config('debug', false);

            $app->error(function(\Exception $e) use ($app) {
                $app->response->apiProblem(array(
                    'detail'    => $e->getMessage(),
                ), ($e->getStatusCode() > 0) ? $e->getStatusCode() : $app->response->getStatus());
            });

            $app->notFound(function() use ($app) {
                $app->response->apiProblem(array(
                    'detail'    => 'The route you are requesting for could not be found. Check the URL to ensure your resource request is spelled correctly.',
                ), 404);
            });
        }

        $this->next->call();
    }
}