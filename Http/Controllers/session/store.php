<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validate($attributes = [
    'email'    => $_POST['email'],
    'password' => $_POST['password']
]);

$auth = new Authenticator();
$signedIn = $auth->attempt($attributes['email'], $attributes['password']);

if (!$signedIn) {
    $form->error('email', 'No matching password found for that email address.')->throw();
}

$role = $auth->getLastUserRole();

if ($role === 'Dumbledore' || $role === 'Professor') {
    redirect('/dashboard');
}

if ($role === 'Student') {
    redirect('/student-panel');
}

redirect('/');