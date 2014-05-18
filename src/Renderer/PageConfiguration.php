<?php

namespace Ampersand\Renderer;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;

/*
 * Catapult page configuration class
 *
 */

class PageConfiguration {

    public $config = array();

    /*
     * Constructor
     */
    public function __construct($file)
    {
        $finder = new Finder();

        $pagePath = $file->getPath();
        $pagesInPath = explode('/',$pagePath);
        $pageConfig = array();

        foreach($pagesInPath as $page)
        {

            $currentPath .= $page.DIRECTORY_SEPARATOR;

            $iterator = $finder
              ->files()
              ->name('index.*')
              ->notName('_*')
              ->notPath('_*')
              ->depth(0)
              ->in($currentPath);

            foreach ($iterator as $parentConfiguration) {
                $pageConfig = array_replace_recursive($pageConfig, $this->readConfiguration($parentConfiguration));
            }

        }

        $this->config = $pageConfig;

        return true;
    }


    /*
     * Read configuration from file
     */
    private function readConfiguration($file)
    {
        switch($file->getExtension()) {

            case 'json':
                $config = json_decode($file->getContents(),true);
                break;

            case 'yml':
            case 'yaml':
                $config = Yaml::parse($file->getContents());
                break;
        }

        # Check if array is returned, otherwise return empty array
        if(!is_array($config)) $config = array();

        return $config;
    }

}


