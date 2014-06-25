<?php

namespace Ampersand\RedBeanPHP;

use R;

/**
 * Class Pages
 *
 * RedBean FUSE Model
 * a place to put validation and business logic
 *
 * @package Ampersand\RedBeanPHP
 */
class Pages extends \RedBeanPHP\SimpleModel
{
    /**
     * R::store() invokes update() and after_update()
     */
    public function update()
    {
        if (!$this->bean->getID()) {
            $this->bean->created_at = R::isoDateTime();
        }
        $this->bean->updated_at = R::isoDateTime();
    }
}