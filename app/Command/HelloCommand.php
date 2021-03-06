<?php
namespace App\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class HelloCommand
 * @package App\Command
*/
class HelloCommand extends Command
{

    /**
     * @var string
    */
    protected $defaultName = 'hello';


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        dump(__METHOD__);

        /* dd($input->getArgument()); */
    }
}