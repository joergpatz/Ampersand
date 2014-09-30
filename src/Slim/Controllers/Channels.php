<?php
namespace Ampersand\Slim\Controllers;

use R;

class Channels extends BaseRESTController
{
    protected static $table = 'channels';
    protected static $fields = 'type,title,layout';
}
