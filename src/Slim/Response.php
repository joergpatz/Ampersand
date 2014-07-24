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
    public function setBody($content)
    {
        $contentType = $this->headers->get('Content-Type');

        if (is_array($content)) {
            if ($contentType === 'application/json') {
                $content = json_encode($content, JSON_NUMERIC_CHECK);
            } else {
                $content = implode(' ', $content);
            }
        }

        parent::setBody($content);
    }
}