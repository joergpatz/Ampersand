<?php
date_default_timezone_set('Europe/Berlin');

/*
 * Start
 */
// define the index working directory
define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Composer autoload
require APP_PATH . 'vendor/autoload.php';

//Start the app
require APP_PATH . 'src/Slim/Start.php';

/*
 * Run
 */
require APP_PATH . 'src/Slim/Routes.php';

$app->run();

