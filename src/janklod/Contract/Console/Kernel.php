<?php
namespace Jan\Contract\Console;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Interface Kernel
 * @package Jan\Contract\Console
*/
interface Kernel
{

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
    */
    public function handle(InputInterface $input, OutputInterface $output);


    /**
     * @param InputInterface $input
     * @param mixed $status
     * @return mixed
    */
    public function terminate(InputInterface $input, $status);
}