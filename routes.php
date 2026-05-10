<?php

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');
$router->delete('/logout', 'session/destroy.php')->only('auth');
$router->get('/', 'HomeController.php');
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
