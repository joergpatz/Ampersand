<?php
namespace Ampersand\Slim\Controllers;

use Ampersand\Slim\Services\ChannelService;

class ChannelsController
{
    static public function index($app)
    {
        $channels = ChannelService::getInstance()->index();

        $app->response->setBody($channels);
    }

    static public function show($app, $id)
    {
        $channel = ChannelService::getInstance()->show($id);

        $app->response->setBody($channel);
    }

    static public function store($app)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $channel = ChannelService::getInstance()->store($body);

        $app->response->setBody($channel);
    }

    static public function update($app, $id)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $channel = ChannelService::getInstance()->update($id, $body);

        $app->response->setBody($channel);
    }

    static public function destroy($app, $id)
    {
        $message = ChannelService::getInstance()->destroy($id);

        $app->response->setBody($message);
    }
}