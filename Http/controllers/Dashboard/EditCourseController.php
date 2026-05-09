<?php

use Core\App;

$db = App::resolve('Core\Database');

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    abort(400);
}

$course = $db->query('SELECT course_id, course_name, professor_id FROM Course WHERE course_id = :id', [
    'id' => $course_id,
])->find();

if (!$course) {
    abort(404);
}

$professors = $db->query('SELECT professor_id, professor_name FROM Professor ORDER BY professor_name')->get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name'] ?? '');
    $professor_id = $_POST['professor_id'] ?? '';

    if (!$course_name || !$professor_id) {
        redirect('/edit-course?id=' . $course_id);
    }

    $professor = $db->query('SELECT professor_id FROM Professor WHERE professor_id = :id', [
        'id' => $professor_id,
    ])->find();

    if (!$professor) {
        redirect('/edit-course?id=' . $course_id);
    }

    $db->query('UPDATE Course SET course_name = :course_name, professor_id = :professor_id WHERE course_id = :course_id', [
        'course_name' => $course_name,
        'professor_id' => $professor_id,
        'course_id' => $course_id,
    ]);

    redirect('/show-course?id=' . $course_id);
}

return view('Dashboard/edit-course.view.php', [
    'course' => $course,
    'professors' => $professors,
]);
