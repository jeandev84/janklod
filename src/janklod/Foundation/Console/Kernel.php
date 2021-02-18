<?php
namespace Jan\Foundation\Console;



use Exception;
use Jan\Component\Config\Config;
use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Contract\Console\Kernel as ConsoleKernelContract;
use Jan\Foundation\Application;
use Jan\Foundation\Command\Make\MakeControllerCommand;
use Jan\Foundation\Command\Make\MakeMigrationCommand;


/**
 * Class Kernel
 * @package Jan\Foundation\Console
*/
class Kernel implements ConsoleKernelContract
{


    protected $commands = [
       MakeControllerCommand::class,
       MakeMigrationCommand::class
    ];


    /**
     * @var Application
    */
    protected $app;


    /**
     * Kernel constructor.
     * @param Application $app
     * @throws Exception
    */
    public function __construct(Application $app)
    {
         $this->app = $app;
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws Exception
    */
    public function handle(InputInterface $input, OutputInterface $output)
    {
        $console = $this->app->get('console');
        $console->setCommands($this->resolvedCommands());
        $console->run($input, $output);
    }


    /**
     * @param InputInterface $input
     * @param mixed $status
     * @return void
    */
    public function terminate(InputInterface $input, $status)
    {

    }


    /**
     * @return array
     * @throws Exception
    */
    protected function resolvedCommands()
    {
        $resolvedCommands = [];

        $config = $this->app->get(Config::class);
        $commands = array_merge($this->commands, $config->get('command', []));

        foreach ($commands as $command)
        {
            if(is_string($command))
            {
                $command =  $this->app->get($command);
            }

            if($command instanceof Command)
            {
                $resolvedCommands[] = $command;
            }
        }

        return $resolvedCommands;
    }
}