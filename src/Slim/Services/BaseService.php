<?php
namespace Ampersand\Slim\Services;

use R;

/**
 * Class BaseService
 *
 * @package Ampersand\Slim\Services
 */
class BaseService implements ServiceInterface
{
    protected $table;
    protected $fields = 'title';

    /**
     * Get class instance
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * Display a listing of all models
     *
     * @return array
     */
    public function index()
    {
        // retrieve all beans from table
        $beans = R::findAll($this->table);

        return R::exportAll($beans);
    }

    /**
     * Display the specified model
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        // retrieve a single bean by ID
        $bean = R::load($this->table, $id);

        //TODO: findOrFail

        return $bean->export();
    }

    /**
     * Store a newly created model in storage
     *
     * @param $body
     * @return array
     */
    public function store($body)
    {
        // create a new bean
        $bean = R::dispense($this->table);
        // import all values from the body data with a property selection
        $bean->import($body, $this->fields);

        R::store($bean);

        // send back the freshly loaded bean
        return $bean->fresh()->export();
    }

    /**
     * Update the specified model in storage
     *
     * @param $id
     * @param $body
     * @return array
     */
    public function update($id, $body)
    {
        // retrieve the single bean object by ID
        $bean = R::load($this->table, $id);

        //TODO: findOrFail

        // import all values from the body data with a property selection
        $bean->import($body, $this->fields);

        R::store($bean);

        // send back the freshly loaded bean
        return $bean->fresh()->export();
    }

    /**
     * Remove the specified model from storage
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        // retrieve a single bean by ID
        $bean = R::load($this->table, $id);

        //TODO: findOrFail

        R::trash($bean);

        return array('message' => 'The '.$this->table.' resource was deleted.');
    }
}