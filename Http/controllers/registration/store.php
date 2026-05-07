<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Password must be at least 8 characters long.';
}
if (count($errors)) {
    return view('registration/create.view.php', [
        'heading' => 'Create an Account',
        'errors' => $errors
    ]);
    exit();
}



$user = $db->query("SELECT * FROM users WHERE email = :email", [
    ':email' => $email
])->find();

if ($user) {
    header('Location: /');
    exit();
} else {
    $db->query("INSERT INTO users (email, password) VALUES (:email, :password)", [
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    (new Authenticator)->login($user);

    header('Location: /');
    exit();
}
