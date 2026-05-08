<?php

// $router->get('URI', 'CONTROLLER');;
// $router->get('uri', 'controller')->only('auth');
// $router->post('uri', 'controller')->only('guest');
// $router->patch('uri', 'controller');
// $router->delete('uri', 'controller')->only('auth');


$router->get('/', 'HomeController.php');
$router->get('/dashboard', 'Dashboard/DashboardController.php');
