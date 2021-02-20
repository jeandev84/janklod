<?php
namespace Jan\Foundation\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class MakeMigrationCommand
 * @package Jan\Foundation\Command
*/
class MakeMigrationCommand extends Command
{
    /**
     * @var string
    */
    protected $name = 'make:migration';



    /**
     * @var string
    */
    protected $description = "make migration class ...";




    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return OutputInterface
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /*
        $argumentName = $input->getArgument('test');
        dd($argumentName);
        */

        return $output->write('Make migration');
    }
}