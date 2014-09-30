<?php
namespace Ampersand\Slim\Controllers;

class Locations extends BaseRESTController
{
    protected static $table = 'locations';
    protected static $fields = 'type,title,latitude,longitude';
}
