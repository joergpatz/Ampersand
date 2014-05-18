<?php
namespace Ampersand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#
# Build Command
#
class BuildCommand extends Command
{

    #
    # Configure
    #
    protected function configure()
    {
        $this->setName('build')->setDescription('Build site');
    }

    #
    # Execute
    #
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $renderer = new \Ampersand\Renderer;
        $output->writeln("Building site...");
        $output->writeln($renderer->renderAll());
    }
}
