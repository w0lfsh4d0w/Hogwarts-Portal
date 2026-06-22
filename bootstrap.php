<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind('Core\Database', function () {

    $config = require BASE_PATH . 'config.php';
    $database = $config['database'];
    $username = $database['username'];
    $password = $database['password'];

    unset($database['username'], $database['password']);

    return new \Core\Database($database, $username, $password);
});

App::setContainer($container);
