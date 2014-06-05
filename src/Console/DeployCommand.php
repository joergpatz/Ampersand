<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Ampersand\Deploy\D;

/**
 * Class for the Deploy Command.
 *
 * @package Ampersand\Console
 */
class DeployCommand extends Command
{

    /**
     * Monolog Logger instance
     *
     * @var \Monolog\Logger
     */
    protected $log;


    /**
     * Command Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('deploy')->setDescription('Deploy site');
        $this->log = new Logger('Deployer');
    }


    /**
     * Execute on Command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->log->pushHandler(new StreamHandler(fopen('php://stdout', 'w')));

        $config = Yaml::parse('config/environments.yml');

        D::setup($config['testftp'], $this->log);

        $this->log->addInfo("Testing connection...");
        if (D::testConnection('ftp')) {
            $this->log->addInfo("Connection OK.");
        } else {
            $this->log->addError("Could not establish connection.");
        }

        $this->log->addInfo("Deploying build directory...");

        D::syncContents('ftp');

        $this->log->addInfo("Fine. Site deployed.");
    }
}
