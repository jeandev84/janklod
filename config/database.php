<?php

return [

    /*
    |------------------------------------------------------------------
    |     CONNECTION TO DATABASE [ mysql, sqlite, pgsql, oci (oracle) ]
    |------------------------------------------------------------------
    */

    'connection' => env('DB_TYPE', 'mysql'),
    'sqlite' => [
        'driver'   => 'sqlite',
        'database' => '../demo.sqlite',
        'options'  => []
    ],
    'mysql' => [
        'driver'    => 'mysql',
        'database'  => env('DB_NAME', 'janklod'),
        'host'      => env('DB_HOST', '127.0.0.1'),
        'port'      => env('DB_PORT', '3306'),
        'username'  => env('DB_USER', 'root'),
        'password'  => env('DB_PASS', ''),
        'collation' => 'utf8_unicode_ci',
        'charset'   => 'utf8',
        'prefix'    => '',
        'engine'    => 'InnoDB', // MyISAM
        'options'   => [],
    ]
];
