<?php

namespace Ampersand\Slim;

/**
 * Response
 *
 * This is a extended simple abstraction over top an HTTP response. This
 * provides methods to set the HTTP status, the HTTP headers,
 * and the HTTP body.
 *
 * @package Ampersand\Slim
 */
class Response extends \Slim\Http\Response
{
    /**
     *  Set content as a json body
     *
     * @param array $content
     */
    public function setJsonBody(array $content)
    {
        parent::setBody(json_encode($content));
    }
}