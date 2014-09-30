<?php
/*
 * Slim Routes
 *
 * please name all content routes (need it for list routes)
 * Syntax: "resources-action"
 *
 * TODO: Refactor route groups to be less repetitive, DRY
 */

// CHANNELS resource
$app->group('/channels', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\Channels', 'index'), $app))->name('channels-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\Channels', 'show'), $app))->name('channels-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\Channels', 'store'), $app))->name('channels-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\Channels', 'update'), $app))->name('channels-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\Channels', 'delete'), $app))->name('channels-delete');
});

// POSTS resource
$app->group('/posts', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\Posts', 'index'), $app))->name('posts-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\Posts', 'show'), $app))->name('posts-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\Posts', 'store'), $app))->name('posts-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\Posts', 'update'), $app))->name('posts-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\Posts', 'delete'), $app))->name('posts-delete');
});

// LOCATIONS resource
$app->group('/locations', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\Locations', 'index'), $app))->name('locations-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\Locations', 'show'), $app))->name('locations-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\Locations', 'store'), $app))->name('locations-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\Locations', 'update'), $app))->name('locations-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\Locations', 'delete'), $app))->name('locations-delete');
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
