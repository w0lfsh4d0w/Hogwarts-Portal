<?php

use Core\Session;

view("path", [
    'key' => "value",
    'errors' => Session::get('errors')
]);