<?php

use Http\Models\UserModel;
use Core\App;
use Core\Database;
use Core\Validator;
use Http\Models\HouseModel;
use Http\Models\StudentModel;
use Core\Authenticator;

$db = App::resolve(Database::class);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

$errors = [];
// check is not empty 
if (!Validator::string($name, 1, 100)) {
    $errors['name'] = 'Please provide a valid name.';
}
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}
if (!Validator::string($password, 8, 255)) {
    $errors['password'] = 'Please provide a password at least eight characters.';
}
if ($password != $password_confirmation) {
    $errors['password_confirmation'] = 'Passwords must match';
};

if (!empty($errors)) {
    return view('registration/create', [
        'errors' => $errors,
        'old'    => ['name' => $name, 'email' => $email]  // so fields don't clear on error
    ]);
}

$user = new  UserModel();
$existingUser = $user->FindUser($email);
if ($existingUser) {
    // is user alrady exist 
    $errors['email'] = 'Email already taken.';
    return view('registration/create', [
        'errors' => $errors,
        'old'    => ['name' => $name, 'email' => $email]  // so fields don't clear on error
    ]);
} else {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userId = $user->CreateUser($name, $email, $hashedPassword);
    $houseModel = new HouseModel();
    $houses = $houseModel->GetHouses();
    $randomIndex = array_rand($houses);
    $houseId = $houses[$randomIndex]['house_id'];
    $studentModel = new StudentModel();
    $studentId = $studentModel->CreateStudent($userId, $houseId);
    $auth = new Authenticator();
    $auth->login([
        'user_id'    => $userId,
        'student_id' => $studentId,
        'email'      => $email,
        'role'       => 'Student',
        'house_id'   => $houseId
    ]);

    header('location: /');
    exit(); //
}
