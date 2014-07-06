<?php

namespace Ampersand\Slim\Middlewares;

/**
 * Class Cors
 *
 * Enable Cross-Origin Resource Sharing (CORS)
 * @link http://www.w3.org/TR/cors/
 *
 * @package Ampersand\Slim\Middlewares
 */
class Cors extends \Slim\Middleware
{
    public function call()
    {
        // Run inner middleware and application
        $this->next->call();

        // Get reference to application
        $app = $this->app;

        // Get current route
        $route = $app->router()->getCurrentRoute();
        $httpMethods = $route->getHttpMethods();

        //if preflight OPTIONS request set some Response Headers which used in it
        if (isset($httpMethods[0]) && $httpMethods[0] === 'OPTIONS') {
            //TODO: if we have more (custom) headers, append there names here
            $app->response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept');

            //NOTE: The PreFlight OPTIONS route must show the possible HTTP methods for a route
            //means e.g. if "index" and "store" action are on one route then you can perform GET, POST on "/pages" uri
            //default switch case is GET, okay then we do NOT need to write ONLY GET actions in a switch case

            // action should the last portion of the name string
            $action = substr(strrchr($route->getName(), '-'), 1);
            switch ($action) {
                case 'index':
                case 'store':
                    $methods = 'GET, POST';
                    break;

                case 'show':
                case 'update':
                case 'delete':
                    $methods = 'GET, PUT, DELETE';
                    break;

                default:
                    $methods = 'GET';
                    break;
            }

            $app->response->headers->set('Access-Control-Allow-Methods', $methods);
            //client can cache the preflight request for the given seconds
            $app->response->headers->set('Access-Control-Max-Age', 86400);
        }

        $app->response->headers->set('Access-Control-Allow-Origin', '*');
        //TODO: if we have custom headers, set there names here
        //$app->response->headers->set('Access-Control-Expose-Headers', '');
    }
}