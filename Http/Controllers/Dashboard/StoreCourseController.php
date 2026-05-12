<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/dashboard#courses';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $professor = require_current_professor($db);

    // Validate input
    if (!$course_name) {
        redirect($redirectTo);
    }

    // Insert Course
    $db->query(
        'INSERT INTO Course (course_name, professor_id) VALUES (:name, :professor_id)',
        [
            'name' => $course_name,
            'professor_id' => $professor['professor_id']
        ]
    );

    redirect($redirectTo);
}
