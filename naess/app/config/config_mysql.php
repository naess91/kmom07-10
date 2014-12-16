<?php

return [
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=ernb14;",
    'username'        => "ernb14",
    'password'        => "Fh8kJ,6r",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "chelsea_",
    'verbose' => false,
    //'debug_connect' => 'true',
];

/*
return [
    'dsn'     => "mysql:host=localhost;dbname=projekt;",
    'username'        => "root",
    'password'        => "root",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    
    'verbose' => false,
    //'debug_connect' => 'true',
];
*/