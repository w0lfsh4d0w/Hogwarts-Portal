<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;
use Controllers\WandController;

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
}

$user = $db->query("SELECT * FROM users WHERE email = :email", [
    ':email' => $email
])->find();

if ($user) {
    header('Location: /');
    exit();
}

$db->query("INSERT INTO users (email, password) VALUES (:email, :password)", [
    ':email' => $email,
    ':password' => password_hash($password, PASSWORD_BCRYPT)
]);

$user = $db->query("SELECT * FROM users WHERE email = :email", [
    ':email' => $email
])->find();

$wand = WandController::createRandomWand();

$db->query("UPDATE users SET wand_id = :wand_id WHERE id = :user_id", [
    ':wand_id' => $wand['id'],
    ':user_id' => $user['id']
]);

$user['wand_id'] = $wand['id'];

(new Authenticator)->login($user);

header('Location: /');
exit();