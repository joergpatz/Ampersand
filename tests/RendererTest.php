<?php

require 'vendor/autoload.php';

use \Ampersand\Renderer;

class RendererTest extends \PHPUnit_Framework_TestCase
{

    public function testIfRendererCanBeInitialized()
    {
        $renderer = new Renderer();
        $this->assertTrue( $renderer instanceof Renderer );
    }

    /*
    public function testIfPagesGetRendered()
    {
        $renderer = new Renderer();
        return true;
    }
     */

}

