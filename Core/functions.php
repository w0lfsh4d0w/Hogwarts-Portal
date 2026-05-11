<?php

use Core\Response;
use Core\Session;

function dd($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

function active($path) {
    return $_SERVER['REQUEST_URI'] === $path ? 'bg-gray-900 text-white' : '';
}

function abort($code = 404) {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
function authorize($condition, $status = Response::FORBIDDEN) {
    if (! $condition)
        abort($status);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function user_role() {
    return current_user()['role'] ?? null;
}

function is_student() {
    return user_role() === 'Student';
}

function is_professor() {
    return user_role() === 'Professor';
}

function is_dumbledore() {
    return user_role() === 'Dumbledore';
}

function is_staff() {
    return in_array(user_role(), ['Dumbledore', 'Professor'], true);
}

function current_professor($db) {
    if (!is_professor()) {
        return null;
    }

    return $db->query('SELECT professor_id, professor_name
            FROM Professor
            WHERE user_id = :user_id
        ', [
        'user_id' => current_user()['user_id'] ?? null,
    ])->find();
}

function require_current_professor($db) {
    $professor = current_professor($db);

    if (!$professor) {
        abort(403);
    }

    return $professor;
}

function base_path($path) {
    return BASE_PATH . $path;
}

function view($path, $attributes = []) {
    extract($attributes);
    require base_path('views/' . $path . '.view.php');
}

function redirect($path) {
    header("Location: {$path}");
    exit();
}

function old($key, $default = ''){
    return Session::get('old')[$key]?? $default;
}
