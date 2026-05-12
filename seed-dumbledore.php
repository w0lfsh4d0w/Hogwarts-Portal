<?php

const BASE_PATH = __DIR__ . '/';

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require base_path("{$class}.php");
});

require base_path('bootstrap.php');

use Core\App;

$db = App::resolve('Core\Database');

$email = 'dumbledore@hogwarts.edu';
$password = 'elderwand123';

$existing = $db->query('SELECT user_id FROM User WHERE email = :email', [
    'email' => $email,
])->find();

if ($existing) {
    $db->query('UPDATE User
            SET user_name = :user_name,
                password = :password,
                role = "Dumbledore"
            WHERE email = :email
        ', [
        'user_name' => 'Albus Percival Wulfric Brian Dumbledore',
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'email' => $email,
    ]);

    echo "Dumbledore super-admin updated.\n";
} else {
    $db->query('INSERT INTO User (user_name, email, password, role)
            VALUES (:user_name, :email, :password, "Dumbledore")
        ', [
        'user_name' => 'Albus Percival Wulfric Brian Dumbledore',
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
    ]);

    echo "Dumbledore super-admin created.\n";
}

echo "Email: {$email}\n";
echo "Password: {$password}\n";
