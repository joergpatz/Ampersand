<?php
/*
 * Slim Routes
 *
 * please name all content routes (need it for list routes)
 * Syntax: "resources-action"
 */

// CHANNELS resource
$app->group('/channels', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\ChannelsController', 'index'), $app))->name('channels-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\ChannelsController', 'show'), $app))->name('channels-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\ChannelsController', 'store'), $app))->name('channels-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\ChannelsController', 'update'), $app))->name('channels-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\ChannelsController', 'destroy'), $app))->name('channels-destroy');
});

// POSTS resource
$app->group('/posts', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\PostsController', 'index'), $app))->name('posts-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\PostsController', 'show'), $app))->name('posts-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\PostsController', 'store'), $app))->name('posts-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\PostsController', 'update'), $app))->name('posts-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\PostsController', 'destroy'), $app))->name('posts-destroy');
});

// LOCATIONS resource
$app->group('/locations', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\LocationsController', 'index'), $app))->name('locations-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\LocationsController', 'show'), $app))->name('locations-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\LocationsController', 'store'), $app))->name('locations-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\LocationsController', 'update'), $app))->name('locations-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\LocationsController', 'destroy'), $app))->name('locations-destroy');
});

// INDEX
$app->get('/', function() use ($app) {
    $app->response->setBody(array('Hello, Ampersand!'));
})->name('home');


// OPTIONS routes for the preflight request, keep it at last
// the Cors middleware will handle the necessary options response headers
$router = $app->router();
foreach($router->getNamedRoutes() as $r) {
    /** @var \Slim\Route $r */
    $app->options($r->getPattern(), function() {
        //OPTIONS routes does not have a body
    })->name('options-'.$r->getName());
}


// define a lazy callable function for calling the Controller Action
function callFunc($callable)
{
    $args = array_slice(func_get_args(), 1);

    return function() use ($callable, $args) {
        return call_user_func_array($callable, array_merge($args, func_get_args()));
    };
}