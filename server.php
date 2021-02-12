<?php
/*-------------------------------------------
|
|  START SERVER
|
/*-------------------------------------------*/

// TODO To create a ServerCommand later for lunch internal server
/*
echo "=========== JanFramework ==============\n\n";
echo "Listen on the port :8080\n";
echo "Server http://localhost:8080\n\n";
echo "=======================================\n\n";
*/
echo "Listen on the port :8080\n";
shell_exec('php -S localhost:8080 -t public -d display_errors=1');
exit(1);
//$output = exec('php -S localhost:8080 -t public -d display_errors=1');
//exit($output);

/*
$console = new \Jan\Foundation\Console();
$console->addCommand(new \App\Command\HelloCommand());
$console->run(new InputArgv(), new ConsoleOutput());
*/

