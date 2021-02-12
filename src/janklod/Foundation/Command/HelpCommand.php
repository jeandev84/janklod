<?php
namespace Jan\Foundation\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;



/**
 * Class HelpCommand
 * @package Jan\Foundation\Command
*/
class HelpCommand extends Command
{

    /**
     * @var string
    */
    protected $defaultName = 'help';


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