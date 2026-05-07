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

function base_path($path) {
    return BASE_PATH . $path;
}

function view($path, $attributes = []) {
    extract($attributes);
    require base_path('views/'. $path ); // /views/index.view.php
}

function redirect($path) {
    header("Location: {$path}");
    exit();
}

function old($key, $default = ''){
    return Session::get('old')[$key]?? $default;
}