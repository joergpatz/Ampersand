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

use Ampersand\Passwordless\Passwordless;
use Ampersand\Passwordless\TokenStore\RedBeanStore;

require 'app/rb.phar';
use R;

#
# Token Command
#
class TokenCommand extends Command
{

    private $log;


    /*
     * Configure
     */
    protected function configure()
    {
        $this->setName('token')
            ->setDescription('Create user auth token')
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'user id for token generation'
            )
            ->addOption(
                'get',
                null,
                InputOption::VALUE_NONE,
                'get user id from store'
            );

        $this->log = new Logger('Token');
    }


    /*
     * Execute
     */
    protected function execute(InputInterface $input, OutputInterface $output)
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

        $this->log->pushHandler(new StreamHandler(fopen('php://stdout', 'w')));
        $passwordless = new Passwordless(new RedBeanStore);

        if($input->getOption('get')){

            $tokens = $passwordless->getUserTokens($input->getArgument('userId'));
            $userId = $passwordless->getUserHash($input->getArgument('userId'));

            foreach($tokens as $token){
                $this->log->addInfo(($token->invalidated ? 'INVALID' : 'VALID').' '.$token->token);
            }

        } else {
            $token = $passwordless->requestToken( $input->getArgument('userId') );
            $this->log->addInfo('Creating token '.$token.' for user id '.$input->getArgument('userId'));
        }
    }
}
