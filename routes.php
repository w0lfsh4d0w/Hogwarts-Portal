<?php

// $router->get('URI', 'CONTROLLER');;
// $router->get('uri', 'controller')->only('auth');
// $router->post('uri', 'controller')->only('guest');
// $router->patch('uri', 'controller');
// $router->delete('uri', 'controller')->only('auth');
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/', 'HomeController.php');