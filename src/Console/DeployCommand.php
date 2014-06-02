<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Ampersand\Deploy\D;

#
# Deploy Command
#
class DeployCommand extends Command
{

    private $log;


    /*
     * Configure
     */
    protected function configure()
    {
        $this->setName('deploy')->setDescription('Deploy site');
        $this->log = new Logger('Deployment');
    }


    /*
     * Execute
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->log = new Logger('Renderer');
        $this->log->pushHandler(new StreamHandler(fopen('php://stdout', 'w')));

        $config = Yaml::parse('config/environments.yml');

        $deploy = D::setup($config['testftp']);

        $this->log->addInfo("Testing connection...");
        if(D::testConnection('ftp')){
            $this->log->addInfo("Connection works");
        } else {
            $this->log->addError("Couldn't establish connection");
        }

        $this->log->addInfo("Deploying build directory");

        D::syncContents('ftp');

        $this->log->addInfo("Deploying site");
    }
}
