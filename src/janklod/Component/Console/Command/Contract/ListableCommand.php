<?php
namespace Jan\Component\Console\Command\Contract;


/**
 * Interface ListableCommand
 *
 * @package Jan\Component\Console\Command\Contract
*/
interface ListableCommand
{
     public function setCommands(array $commandLists);
}