<?php
/*
 * Slim Routes
 *
 * please name all content routes (need it for list routes)
 * Syntax: "resources-action"
 */

// PAGES resource
$app->group('/pages', function() use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'index'), $app))->name('pages-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'show'), $app))->name('pages-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'store'), $app))->name('pages-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'update'), $app))->name('pages-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'delete'), $app))->name('pages-delete');
});

// INDEX
$app->get('/', function() {
    echo "Hello, Ampersand!";
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