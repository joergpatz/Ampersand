<?php
namespace Ampersand\Slim\Controllers;

use R;

class Pages
{
    private static $table = 'pages';

    static public function index($app)
    {
        // retrieve all beans in pages table and convert them to an array
        $pages = R::exportAll(R::findAll(self::$table));

        $app->response->setBody($pages);
    }

    static public function show($app, $id)
    {
        // retrieve a single bean by ID and convert it to an array
        $page = R::load(self::$table, $id)->export();

        //TODO: findOrFail

        $app->response->setBody($page);
    }

    static public function store($app)
    {
        //get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        //create a new page
        $page = R::dispense(self::$table);
        $page->title = $body['title'];
        $page->layout = $body['layout'];

        $id = R::store($page);

        // retrieve the created bean by ID and send back to the client
        $page = R::load(self::$table, $id)->export();

        $app->response->setBody($page);
    }
}