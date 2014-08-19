<?php
namespace Ampersand\Slim\Controllers;

use R;

class Channels
{
    private static $table = 'channels';

    static public function index($app)
    {
        // retrieve all beans from channels table
        $channels = R::findAll(self::$table);

        $app->response->setBody(R::exportAll($channels));
    }

    static public function show($app, $id)
    {
        // retrieve a single bean by ID
        $channel = R::load(self::$table, $id);

        //TODO: findOrFail

        $app->response->setBody($channel->export());
    }

    static public function store($app)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        // create a new channel
        $channel = R::dispense(self::$table);
        // import all values from the body data with a property selection
        $channel->import($body, 'type,title,layout');

        R::store($channel);

        // send back the freshly loaded bean
        $app->response->setBody($channel->fresh()->export());
    }

    static public function update($app, $id)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        // retrieve the single bean object by ID
        $channel = R::load(self::$table, $id);

        //TODO: findOrFail

        // import all values from the body data with a property selection
        $channel->import($body, 'type,title,layout');

        R::store($channel);

        // send back the freshly loaded bean
        $app->response->setBody($channel->fresh()->export());
    }

    static public function delete($app, $id)
    {
        // retrieve a single bean by ID
        $channel = R::load(self::$table, $id);

        //TODO: findOrFail

        R::trash($channel);

        $app->response->setBody(array('message' => 'The channel resource was deleted.'));
    }
}