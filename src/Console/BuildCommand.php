<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

#
# Build Command
#
class BuildCommand extends Command
{

    private $log;


    /*
     * Configure
     */
    protected function configure()
    {
        $this->setName('build')->setDescription('Build site');
        $this->log = new Logger('Renderer');
    }


    /*
     * Execute
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->log->pushHandler(new StreamHandler(fopen('php://stdout', 'w')));

        $renderer = new \Ampersand\Renderer;
        $this->log->addInfo('Building site...');
        $renderer->renderAll();
    }
}
