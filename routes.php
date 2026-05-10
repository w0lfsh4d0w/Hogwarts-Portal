<?php

// $router->get('URI', 'CONTROLLER');;
// $router->get('uri', 'controller')->only('auth');
// $router->post('uri', 'controller')->only('guest');
// $router->patch('uri', 'controller');
// $router->delete('uri', 'controller')->only('auth');



 $router->get('/shop', 'ShopController.php');

// $router->post('/shop/buy', 'ShopController@buy');

// $router->get('/inventory', 'InventoryController@index');

// $router->post('/inventory/remove', 'InventoryController@remove');
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');
$router->delete('/logout', 'session/destroy.php')->only('auth');
$router->get('/', 'HomeController.php');
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
