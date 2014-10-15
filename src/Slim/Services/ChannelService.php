<?php
namespace Ampersand\Slim\Services;


class ChannelService extends BaseService
{
    protected $table    = 'channels';
    protected $fields   = 'type,title,layout';
}