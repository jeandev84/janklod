#!/usr/bin/env php
<?php

/*
|------------------------------------------------------------------
|   Framework console
|   Ex: $ php console --help or -h
|   Ex: $ php console make:command SayHelloCommand
|   Ex: $ php console make:controller HomeController
|   Ex: $ php console make:model User
|   Ex: $ php console server (run server)
|------------------------------------------------------------------
*/

require(__DIR__ . '/vendor/autoload.php');
$app = require(__DIR__ . '/bootstrap/app.php');


$kernel = $app->get(Jan\Contract\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Jan\Component\Console\Input\ArgvInput(),
    new Jan\Component\Console\Output\ConsoleOutput()
);

$kernel->terminate($input, $status);
exit($status);