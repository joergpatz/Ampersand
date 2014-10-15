<?php
namespace Ampersand\Slim\Services;


/**
 * Interface ServiceInterface
 *
 * @package Ampersand\Slim\Services
 */
interface ServiceInterface
{
    public static function getInstance();

    public function index();

    public function show($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);
}