<?php
namespace Ampersand\Slim\Controllers;

use R;

class Pages
{
    private static $table = 'pages';

    static public function index($app)
    {
        // retrieve all beans from pages table
        $pages = R::findAll(self::$table);

        $app->response->setBody(R::exportAll($pages));
    }

    static public function show($app, $id)
    {
        // retrieve a single bean by ID
        $page = R::load(self::$table, $id);

        //TODO: findOrFail

        $app->response->setBody($page->export());
    }

    static public function store($app)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        // create a new page
        $page = R::dispense(self::$table);
        // import all values from the body data with a property selection
        $page->import($body, 'title,layout');
        $page->created_at = R::isoDateTime();
        $page->updated_at = R::isoDateTime();

        R::store($page);

        // send back the freshly loaded bean
        $app->response->setBody($page->fresh()->export());
    }

    static public function update($app, $id)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        // retrieve the single bean object by ID
        $page = R::load(self::$table, $id);

        //TODO: findOrFail

        // import all values from the body data with a property selection
        $page->import($body, 'title,layout');
        $page->updated_at = R::isoDateTime();

        R::store($page);

        // send back the freshly loaded bean
        $app->response->setBody($page->fresh()->export());
    }

    static public function delete($app, $id)
    {
        // retrieve a single bean by ID
        $page = R::load(self::$table, $id);

        //TODO: findOrFail

        R::trash($page);

        $app->response->setBody(array('message' => 'The page resource was deleted.'));
    }
}