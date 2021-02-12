<?php
namespace Jan\Component\Console\Command\Contract;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Interface ReversibleCommand
 *
 * @package Jan\Component\Console\Command\Contract
*/
interface ReversibleCommand
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
    */
    public function undo(InputInterface $input, OutputInterface $output);
}