<?php

namespace Ampersand;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Ampersand\HTML\Page;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require 'app/rb.phar';
use R;


class Renderer
{

    private $dbConfig;

    private $renderDirectory = 'build';

    private $log;


    #
    # Construct
    #
    public function __construct()
    {
        $this->dbConfig = Yaml::parse('config/database.yml');

        $this->log = new Logger('Renderer');

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

        $page = new Page(array(
            'layout_directory' => 'bundles/default/layouts/',
            'cache_directory' => 'tmp/templates/',
            'logger' => $this->log
        ));
        $page->setTitle($pageRecord['title']);

        if(!empty($pageRecord['layout'])){
            $page->setLayout($pageRecord['layout']);
        }

        $destinationPath = $this->renderDirectory.DIRECTORY_SEPARATOR;
        $destinationFile = $this->sanitizePageTitle($page->getTitle()).'.html';

        # Create directory if it doesn't exist
        $filesystem->mkdir($destinationPath, $mode = 0775);

        file_put_contents($destinationPath.$destinationFile, $page->render());

        $this->log->addInfo("Rendering page ".$page->getTitle()." to ".$destinationFile);
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

        $this->log->addInfo("Finished rendering pages");
    }


    private function sanitizePageTitle($title)
    {
        return strToLower($title);
    }

}
