<?php
namespace Ampersand\Slim\Services;


class LocationService extends BaseService
{
    protected $table    = 'locations';
    protected $fields   = 'type,title,latitude,longitude';
}