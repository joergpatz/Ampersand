<?php
/*
 * Slim Routes
 */

// define a lazy callable function for calling the Controller Action
function callFunc($callable)
{
    $args = array_slice(func_get_args(), 1);

    return function() use ($callable, $args) {
        return call_user_func_array($callable, array_merge($args, func_get_args()));
    };
}

//PAGES
$app->group('/pages', function () use ($app) {
    $app->get('/', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'index'), $app))->name('pages-index');
    $app->get('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'show'), $app))->name('pages-show');
    $app->post('/', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'store'), $app))->name('pages-store');
    $app->put('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'update'), $app))->name('pages-update');
    $app->delete('/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'destroy'), $app))->name('pages-delete');
});

$app->get('/', function () {
    echo "Hello, Ampersand!";
});
