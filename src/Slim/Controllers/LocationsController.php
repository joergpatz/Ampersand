<?php
namespace Ampersand\Slim\Controllers;

use Ampersand\Slim\Services\LocationService;

class LocationsController
{
    static public function index($app)
    {
        $locations = LocationService::getInstance()->index();

        $app->response->setBody($locations);
    }

    static public function show($app, $id)
    {
        $location = LocationService::getInstance()->show($id);

        $app->response->setBody($location);
    }

    static public function store($app)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $location = LocationService::getInstance()->store($body);

        $app->response->setBody($location);
    }

    static public function update($app, $id)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $location = LocationService::getInstance()->update($id, $body);

        $app->response->setBody($location);
    }

    static public function destroy($app, $id)
    {
        $message = LocationService::getInstance()->destroy($id);

        $app->response->setBody($message);
    }
}