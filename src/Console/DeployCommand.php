<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

use Ampersand\Deploy\D;

#
# Deploy Command
#
class DeployCommand extends Command
{

    #
    # Configure
    #
    protected function configure()
    {
        $this->setName('deploy')->setDescription('Deploy site');
    }

    #
    # Execute
    #
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = Yaml::parse('config/environments.yml');
        #$output->writeln(print_r($config,true));

        $deploy = D::setup($config['testftp']);

        $output->writeln("Testing connection ...");
        if(D::testConnection('ftp')){
            $output->writeln("Connection works.");
        }

        $output->writeln("Deploying build directory");

        D::syncContents('ftp');

        $output->writeln("Deploying site...");
    }
}
