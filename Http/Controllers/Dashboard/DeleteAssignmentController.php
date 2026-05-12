<?php

use Core\App;

$db = App::resolve('Core\Database');
$professor = require_current_professor($db);

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignment = $db->query('SELECT
        Assignment.assignment_id,
        Assignment.title,
        Assignment.assignment_type,
        Course.course_name,
        COUNT(Submission.submission_id) AS submissions_count
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
        WHERE Assignment.assignment_id = :id
            AND Course.professor_id = :professor_id
        GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type, Course.course_name
        ', [
    'id' => $assignment_id,
    'professor_id' => $professor['professor_id'],
])->find();

if (!$assignment) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->query('DELETE hp FROM HousePoints hp
            JOIN Submission s ON hp.submission_id = s.submission_id
            WHERE s.assign_id = :id
        ', [
        'id' => $assignment_id,
    ]);

    $db->query('DELETE FROM Assignment WHERE assignment_id = :id', [
        'id' => $assignment_id,
    ]);

    redirect('/dashboard');
}

return view('Dashboard/delete-assignment', [
    'assignment' => $assignment,
]);
