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

$app->get('/pages/:id', callFunc(array('\Ampersand\Slim\Controllers\Pages', 'index'), $app))->name('pages-index');

$app->get('/', function () {
    echo "Hello, Ampersand!";
});