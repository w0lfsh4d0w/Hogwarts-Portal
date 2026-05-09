<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/dashboard#students';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $house_name = $_POST['house'] ?? '';
    $balance = (float) ($_POST['balance'] ?? 1000.00);
    $wood_type = $_POST['wood_type'] ?? '';
    $core_type = $_POST['core_type'] ?? '';

    // Validate input
    $validWoods = ['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'];
    $validCores = ['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'];

    if (
        !$user_name ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !$password ||
        !$house_name ||
        !in_array($wood_type, $validWoods, true) ||
        !in_array($core_type, $validCores, true) ||
        $balance < 0
    ) {
        redirect($redirectTo);
    }

    // Get house ID
    $house = $db->query('SELECT house_id FROM House WHERE house_name = :name', ['name' => $house_name])->find();
    if (!$house) {
        redirect($redirectTo);
    }

    // Check if email already exists
    $existing = $db->query('SELECT user_id FROM User WHERE email = :email', ['email' => $email])->find();
    if ($existing) {
        redirect($redirectTo);
    }

    // Insert User
    $db->query(
        'INSERT INTO User (user_name, email, password, role) VALUES (:name, :email, :password, :role)',
        [
            'name' => $user_name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'Student'
        ]
    );

    $user_id = $db->connection->lastInsertId();

    // Insert Student
    $db->query(
        'INSERT INTO Student (user_id, house_id, balance, status) VALUES (:user_id, :house_id, :balance, :status)',
        [
            'user_id' => $user_id,
            'house_id' => $house['house_id'],
            'balance' => $balance,
            'status' => 'Active'
        ]
    );

    $student_id = $db->connection->lastInsertId();

    // Insert Wand
    $db->query(
        'INSERT INTO Wand (student_id, wood_type, core_type) VALUES (:student_id, :wood_type, :core_type)',
        [
            'student_id' => $student_id,
            'wood_type' => $wood_type,
            'core_type' => $core_type
        ]
    );

    redirect($redirectTo);
}
