<?php
namespace Ampersand\Slim\Controllers;

class Posts extends BaseRESTController
{
    protected static $table = 'posts';
    protected static $fields = 'type,title,content';
}
