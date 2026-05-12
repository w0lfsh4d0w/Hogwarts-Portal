<?php

use Core\App;

$db = App::resolve('Core\Database');
$professor = require_current_professor($db);

$student_id = $_GET['id'] ?? null;

if (!$student_id) {
    abort(400);
}

authorize(professor_owns_student($db, $student_id, $professor['professor_id']));

$student = $db->query('SELECT * FROM Student WHERE student_id = :id', ['id' => $student_id])->find();

if (!$student) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->query('UPDATE Student SET status = :status WHERE student_id = :id', [
        'status' => 'Inactive',
        'id' => $student_id
    ]);

    redirect('/dashboard');
}

return view('Dashboard/deactivate-student', [
    'student' => $student,
]);
