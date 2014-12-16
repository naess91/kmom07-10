<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactory();

 $di->set('CommentController', function() use ($di) {
        $controller = new \Anax\Comments\CommentController();
        $controller->setDI($di);
        return $controller;
    });

 $di->set('UsersController', function() use ($di) {
        $controller = new \Anax\Users\UsersController();
        $controller->setDI($di);
        return $controller;
    });
$app = new \Anax\MVC\CApplicationBasic($di);



