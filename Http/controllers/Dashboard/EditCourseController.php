<?php

use Core\App;

$db = App::resolve('Core\Database');
$professor = require_current_professor($db);

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    abort(400);
}

$course = $db->query('SELECT course_id, course_name, professor_id
        FROM Course
        WHERE course_id = :id AND professor_id = :professor_id
    ', [
    'id' => $course_id,
    'professor_id' => $professor['professor_id'],
])->find();

if (!$course) {
    abort(404);
}

$professors = [$professor];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $professor_id = $professor['professor_id'];

    if (!$course_name || !$professor_id) {
        redirect('/edit-course?id=' . $course_id);
    }

    $db->query('UPDATE Course SET course_name = :course_name, professor_id = :professor_id WHERE course_id = :course_id', [
        'course_name' => $course_name,
        'professor_id' => $professor_id,
        'course_id' => $course_id,
    ]);

    redirect('/show-course?id=' . $course_id);
}

return view('Dashboard/edit-course', [
    'course' => $course,
    'professors' => $professors,
]);
