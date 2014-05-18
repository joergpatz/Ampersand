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


    public function render($pageId)
    {
        $filesystem = new Filesystem();
        $pageRecord = R::getRow('SELECT * FROM pages WHERE id = ?',[$pageId]);

        $page = new Page;
        $page->setTitle($pageRecord['title']);

        $destinationPath = $this->renderDirectory.DIRECTORY_SEPARATOR;
        $destinationFile = $this->sanitizePageTitle($page->getTitle()).'.html';

        # Create directory if it doesn't exist
        $filesystem->mkdir($destinationPath, $mode = 0775);

        file_put_contents($destinationPath.$destinationFile, $page->render());
        echo($page->getTitle().'\n');
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

}
