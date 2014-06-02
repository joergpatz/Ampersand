<?php

namespace Ampersand;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Ampersand\HTML\Page;

require 'app/rb.phar';
use R;


class Renderer {

    private $dbConfig;

    private $renderDirectory = 'build';


    #
    # Construct
    #
    public function __construct()
    {
        $this->dbConfig = Yaml::parse('config/database.yml');

        #
        # Set up Redbean database according to database configuration
        #
        switch($this->dbConfig['type']){

            case 'sqlite':  R::setup('sqlite:'.$this->dbConfig['file']);
                            break;

            case 'mysql':   R::setup($this->dbConfig["type"].':.host='.$this->dbConfig["host"].';dbname='.$this->dbConfig["database"],$this->dbConfig["username"],$this->dbConfig["password"]);
                            break;

        }

        return $this;
    }


    public function __destruct()
    {
        R::close();
    }


    public function render($pageId)
    {
        $filesystem = new Filesystem();
        $pageRecord = R::getRow('SELECT * FROM pages WHERE id = ?', array($pageId));

        $page = new Page;
        $page->setTitle($pageRecord['title']);

        if(!empty($pageRecord['layout'])){
            $page->setLayout($this->getLayout($pageRecord['layout']));
        }

        $destinationPath = $this->renderDirectory.DIRECTORY_SEPARATOR;
        $destinationFile = $this->sanitizePageTitle($page->getTitle()).'.html';

        # Create directory if it doesn't exist
        $filesystem->mkdir($destinationPath, $mode = 0775);

        file_put_contents($destinationPath.$destinationFile, $page->render());
        print $page->getTitle()." [".$destinationFile."] \n";
    }


    #
    # Render function
    #
    public function renderAll()
    {
        $pages = R::getAssoc('SELECT id,title FROM pages');

        if(is_array($pages) && count($pages) > 0){
            foreach($pages as $key => $title){
                $this->render($key);
            }
        }

        return "Finished";
    }


    private function sanitizePageTitle($title)
    {
        return strToLower($title);
    }


    private function getLayout($layoutId)
    {
        $layoutIdParts = explode('/',$layoutId);

        $bundleId = !empty($layoutIdParts[0]) ? $layoutIdParts[0] : false;
        if(!$bundleId) return false;

        $layoutId = !empty($layoutIdParts[1]) ? $layoutIdParts[1] : 'index';

        $layoutFilePath = 'bundles'.DIRECTORY_SEPARATOR.$bundleId.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR.$layoutId.'.html';

        if(file_exists($layoutFilePath)){
            return file_get_contents($layoutFilePath);
        } else {
            print("Can't find layout ".$layoutFilePath."\n");
        }

        return false;
    }
}
