<?php
namespace Jan\Foundation;


use Jan\Component\Console\Command\Command;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Output\Contract\OutputInterface;
use Jan\Foundation\Command\HelpCommand;
use Jan\Foundation\Command\ListCommand;
use Jan\Component\Console\Command\Contract\ListableCommand;




/**
 * Class Console
 * @package Jan\Foundation
*/
class Console
{

      /**
        * @var string
      */
      protected $defaultCommand = 'list';


      /**
       * @var string
      */
      protected $helpCommand = 'help';


      /**
       * @var array
      */
      protected $commands = [];



      /**
        * Console constructor.
      */
      public function __construct()
      {
          $this->setDefaultCommands();
      }


      /**
       * Load default commands
      */
      protected function setDefaultCommands()
      {
          $this->setCommands([
              new ListCommand(),
              new HelpCommand()
          ]);
      }


      /**
       * @param Command $command
       * @return Command
       */
      public function add(Command $command): Command
      {
          $this->commands[$command->getName()] = $command;

          return $command;
      }


      /**
        * @param array $commands
        * @return Console
      */
      public function setCommands(array $commands): Console
      {
           foreach ($commands as $command)
           {
               $this->add($command);
           }

           return $this;
      }


      /**
       * @return array
      */
      public function getCommands(): array
      {
          return $this->commands;
      }


      /**
       * @param string $name
        * @return Command
      */
      public function getCommand(string $name): Command
      {
           return $this->commands[$name];
      }


      /**
       * @param InputInterface $input
       * @param OutputInterface $output
       * @return mixed
       * @throws \Exception
      */
      public function run(InputInterface $input, OutputInterface $output)
      {
          /* dd($this->commands); */
          // lunch ListCommand or Help Command
          echo "========================================\n";
          echo "\n";
          echo "    WELCOME TO JANKLOD FRAMEWORK! \n";
          echo "\n";
          echo "========================================\n";

          $entryPoint = $input->getFirstArgument();
          $name  = $this->resolveParse($entryPoint);

          if(! $this->isValidCommand($name))
          {
              dd("Invalid command!\n");
          }

          $command  = $this->getCommand($name);
          $inputBug = $command->getInputBag();

          $input->bind($inputBug);

          $implements = class_implements($command);

          if(isset($implements[ListableCommand::class]))
          {
              if(method_exists($command, "setCommands"))
              {
                  $command->setCommands($this->getListableCommands());
              }
          }

          return $command->execute($input, $output);
      }


      /**
       * @param string $name
       * @return false
      */
      public function isValidCommand(string $name): bool
      {
          return \array_key_exists($name, $this->commands);
      }


      /**
       * @return array
      */
      protected function getListableCommands(): array
      {
          /*
           unset($this->commands[$this->defaultCommand], $this->commands[$this->helpCommand]);
          */
          unset($this->commands[$this->defaultCommand]);

          return $this->commands;
      }


      /**
       * @param $name
       * @return mixed|string
      */
      protected function resolveParse(string $name): string
      {
          if(! $name)
          {
              return $this->defaultCommand;
          }

          if(\in_array($name, ['--help', '-h']))
          {
              return $this->helpCommand;
          }

          return $name;
      }
}