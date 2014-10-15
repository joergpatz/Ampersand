<?php
namespace Ampersand\Slim\Services;


class PostService extends BaseService
{
    protected $table    = 'posts';
    protected $fields   = 'type,title,content';
}