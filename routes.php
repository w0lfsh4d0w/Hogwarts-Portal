<?php
// Shop
$router->get('/shop', 'shop/index.php')->only('auth');
$router->post('/shop/buy', 'shop/store.php')->only('auth');

// Inventory
$router->get('/inventory', 'inventory/index.php')->only('auth');
$router->post('/inventory/remove', 'inventory/store.php')->only('auth');

// Registration
$router->get('/register', 'registration/create.php')->only('guest');
// $router->post('/register', 'registration/store.php')->only('guest');

// Session
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->delete('/logout', 'session/destroy.php')->only('auth');

// Home
$router->get('/', 'HomeController.php');