<?php
namespace Jan\Foundation\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Command\Contract\ListableCommand;
use Jan\Component\Console\Exception\InvalidArgumentException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class ListCommand
 * @package Jan\Foundation\Command
*/
class ListCommand extends Command implements ListableCommand
{

    /**
     * @var string
    */
    protected $defaultName = 'list';


    /**
     * @var array
    */
    protected $commandLists = [];


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* dd($input->getArgument()); */

        echo $this->buildList();

        /* d($this->commandLists); */
        exit;
    }


    /**
     * @param array $commandLists
    */
    public function setCommands(array $commandLists)
    {
         $this->commandLists = $commandLists;
    }


    /**
     * @return string
     * @throws InvalidArgumentException
    */
    protected function buildList()
    {
        $commandList = [];

        foreach ($this->commandLists as $command)
        {
            if($command instanceof Command)
            {
                 $name = $command->getName();

                 if(stripos($name, ':') !== false)
                 {
                     $leftPart = explode(':', $name)[0];
                     $commandList[$leftPart][] = $command;
                 }else{
                     $commandList[$name][] = $command;
                 }
            }
        }

        // dd($commandList);
        $consolePrint = "\n";

        // dd($commandList);
        foreach ($commandList as $index => $commands)
        {
             $consolePrint .= $index .":\n";

             foreach ($commands as $command)
             {
                 if($command instanceof Command)
                 {
                     $consolePrint .= " ". $command->getName() . "  ". $command->getDescription() . "\n";
                 }
             }
        }

        return $consolePrint;
    }
}