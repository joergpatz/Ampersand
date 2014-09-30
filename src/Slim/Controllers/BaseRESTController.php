<?php

namespace Ampersand\Slim\Controllers;

use R;

class BaseRESTController
{

    static protected $table;
    static protected $fields = 'title';


    static public function index($app)
    {
        # retrieve all beans from the table
        $records = R::findAll(static::$table);
        $app->response->setBody(R::exportAll($records));
    }


    static public function show($app, $id)
    {
        # retrieve a single bean by ID
        $record = R::load(static::$table, $id);
        $app->response->setBody($record->export());
    }


    static public function store($app)
    {
        # get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        # create a new record
        $record = R::dispense(static::$table);
        # import all values from the body data with a property selection
        $record->import($body, static::$fields);

        R::store($record);
        $app->log->info("Stored a new ".static::$table);

        # send back the freshly loaded bean
        $app->response->setBody($record->fresh()->export());
    }


    static public function update($app, $id)
    {
        # get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        # retrieve the single bean object by ID
        $record = R::load(static::$table, $id);

        # import all values from the body data with a property selection
        $record->import($body, static::$fields);

        R::store($record);
        $app->log->info("Updated ".static::$table." with id ".$id);

        # send back the freshly loaded bean
        $app->response->setBody($record->fresh()->export());
    }


    static public function delete($app, $id)
    {
        # retrieve a single bean by ID
        $record = R::load(static::$table, $id);

        R::trash($record);
        $app->log->info("Deleted ".static::$table." with id ".$id);

        $app->response->setBody(array('message' => 'The resource was deleted.'));
    }

}
