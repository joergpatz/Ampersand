<?php
use Symfony\Component\Yaml\Yaml;

/*
 * setup Redbean ORM
 */
require APP_PATH . 'app/rb.phar';

// Database initialization
$dbConfig = Yaml::parse(APP_PATH . 'config/database.yml');

// Set up Redbean database according to database configuration
switch($dbConfig['type']) {

    case 'sqlite':  R::setup('sqlite:'.$dbConfig['file']);
                    break;

    case 'mysql':   R::setup($dbConfig['type'].':.host='.$this->dbConfig['host'].';dbname='.$this->dbConfig['database'],$this->dbConfig['username'],$this->dbConfig['password']);
                    break;
}

// rb Models Observer need a namespacing constant for fusing beans with models
define('REDBEAN_MODEL_PREFIX', '\\Ampersand\\RedBeanPHP\\');

/*
 * create a new Slim application instance
 */
$settings = Yaml::parse(APP_PATH . 'config/settings.yml');

date_default_timezone_set($settings['timezone']);

$app = new \Slim\Slim(array(
    'mode' => $settings['mode']
));

// Override Slim's default Response object
$app->container->singleton('response', function() {
    return new \Ampersand\Slim\Response();
});

$app->setName('Ampersand');
$app->add(new \Slim\Middleware\ContentTypes());
$app->add(new \Ampersand\Slim\Middlewares\Cors());
$app->add(new \Ampersand\Slim\Middlewares\AcceptHeader());