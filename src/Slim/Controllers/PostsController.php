<?php
namespace Ampersand\Slim\Controllers;

use Ampersand\Slim\Services\PostService;

class PostsController
{
    static public function index($app)
    {
        $posts = PostService::getInstance()->index();

        $app->response->setBody($posts);
    }

    static public function show($app, $id)
    {
        $post = PostService::getInstance()->show($id);

        $app->response->setBody($post);
    }

    static public function store($app)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $post = PostService::getInstance()->store($body);

        $app->response->setBody($post);
    }

    static public function update($app, $id)
    {
        // get the request body, a middleware automatically convert the json to an array
        $body = $app->request->getBody();

        $post = PostService::getInstance()->update($id, $body);

        $app->response->setBody($post);
    }

    static public function destroy($app, $id)
    {
        $message = PostService::getInstance()->destroy($id);

        $app->response->setBody($message);
    }
}