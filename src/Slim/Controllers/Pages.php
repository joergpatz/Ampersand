<?php
namespace Ampersand\Slim\Controllers;

use R;

class Pages
{
    private static $table = 'pages';

    static public function index($app)
    {
        $pages = R::exportAll(R::findAll(self::$table));

        $app->response->setBody($pages);
    }
}