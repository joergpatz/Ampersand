<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
        //$deploy = D::setup();

        $output->writeln("Deploying site...");
    }
}
