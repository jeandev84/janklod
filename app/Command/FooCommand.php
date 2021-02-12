<?php
namespace App\Command;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class FooCommand
 *
 * @package App\Command
*/
class FooCommand extends Command
{

    public function configure()
    {
        $this->setName('make:foo')
             ->setDescription('do something foo ...')
             ->setHelp('help command make:foo') // -h
             ->addArgument('a', 'some argument desc a', 0)
             ->addArgument('b', 'some argument desc b', 0)
             ->addOption('c', '-c', 'some option desc c', 0)
             ->addOption('d', '-d', 'some option desc d', 0)
        ; // some help ...
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws Exception
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
          dump($this->getArguments());
          dump($this->getOptions());
          dd("I'm making foo\n");
    }
}