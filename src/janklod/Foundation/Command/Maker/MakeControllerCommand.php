<?php
namespace Jan\Foundation\Command\Maker;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class MakeControllerCommand
 *
 * @package Jan\Foundation\Commands\Maker
*/
class MakeControllerCommand extends Command
{

    /**
     * @var string
    */
    protected $name = 'make:controller';


    /**
     * @var string
    */
    protected $description = "make controller class ...";


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed|void
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        dump(__METHOD__);
    }
}