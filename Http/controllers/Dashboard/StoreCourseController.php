<?php

use Core\App;

$db = App::resolve('Core\Database');
$redirectTo = '/dashboard#courses';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $professor_id = $_POST['professor_id'] ?? '';

    // Validate input
    if (!$course_name || !$professor_id) {
        redirect($redirectTo);
    }

    // Verify professor exists
    $professor = $db->query('SELECT professor_id FROM Professor WHERE professor_id = :id', 
        ['id' => $professor_id])->find();
    if (!$professor) {
        redirect($redirectTo);
    }

    // Insert Course
    $db->query(
        'INSERT INTO Course (course_name, professor_id) VALUES (:name, :professor_id)',
        [
            'name' => $course_name,
            'professor_id' => $professor_id
        ]
    );

    redirect($redirectTo);
}
