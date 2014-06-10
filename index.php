<?php

require 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

// Redbean ORM
require 'app/rb.phar';

### Database initialization
$dbConfig = Yaml::parse('config/database.yml');

#
# Set up Redbean database according to database configuration
#
switch($dbConfig['type']){

    case 'sqlite':  R::setup('sqlite:'.$dbConfig['file']);
                    break;

    case 'mysql':   R::setup($dbConfig["type"].':.host='.$this->dbConfig["host"].';dbname='.$this->dbConfig["database"],$this->dbConfig["username"],$this->dbConfig["password"]);
                    break;
}


$app = new \Slim\Slim;

// Pages routes
$app->get('/pages', function () use ($app){

    $pages = R::getAssoc('SELECT * FROM pages');

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($pages);

});


$app->get('/', function () {
    echo "Hello, Ampersand";
});


$app->run();

