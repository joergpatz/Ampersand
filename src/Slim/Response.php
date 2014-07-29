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
                $content = '<pre>' . var_export($content, true) . '</pre>';
            }
        }

        parent::setBody($content);
    }

    public function apiProblem($data = array(), $status = 500)
    {
        $app = \Slim\Slim::getInstance();

        $this->headers->set('Content-Type', 'application/api-problem+json');

        //fill mandatory title
        $data['title'] = $this->getMessageForCode($status);

        //check optional fields
        if (empty($data['detail'])) $data['detail'] = '';
        if (empty($data['instance'])) $data['instance'] = $app->request->getUrl() . $app->request->getPath();

        //create api-problem object
        $problem = new \Crell\ApiProblem\ApiProblem($data['title'], "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html");
        $problem->setDetail($data['detail']);
        $problem->setProblemInstance($data['instance']);
        $problem->setHttpStatus($status);

        $app->halt($status, $problem->asJson());
    }
}