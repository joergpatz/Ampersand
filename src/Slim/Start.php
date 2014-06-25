<?php
date_default_timezone_set('Europe/Berlin');

/*
 * setup Redbean ORM
 */
require APP_PATH . 'app/rb.phar';

use Symfony\Component\Yaml\Yaml;

// Database initialization
$dbConfig = Yaml::parse(APP_PATH . 'config/database.yml');

// Set up Redbean database according to database configuration
switch($dbConfig['type']) {

    case 'sqlite':  R::setup('sqlite:'.$dbConfig['file']);
                    break;

    case 'mysql':   R::setup($dbConfig["type"].':.host='.$this->dbConfig["host"].';dbname='.$this->dbConfig["database"],$this->dbConfig["username"],$this->dbConfig["password"]);
                    break;
}

// rb Models Observer need a namespacing constant for fusing beans with models
define('REDBEAN_MODEL_PREFIX', '\\Ampersand\\RedBeanPHP\\');

/*
 * create a new Slim application instance
 */
$app = new \Slim\Slim;

// Override Slim's default Response object
$app->container->singleton('response', function () {
    return new \Ampersand\Slim\Response();
});

$app->setName('Ampersand');
$app->add(new \Slim\Middleware\ContentTypes());
$app->add(new \Ampersand\Slim\Middlewares\AcceptHeader());