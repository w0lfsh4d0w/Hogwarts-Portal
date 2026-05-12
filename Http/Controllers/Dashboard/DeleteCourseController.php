<?php

use Core\App;

$db = App::resolve('Core\Database');
$professor = require_current_professor($db);

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    abort(400);
}

$course = $db->query('SELECT
        Course.course_id,
        Course.course_name,
        Professor.professor_name,
        COUNT(DISTINCT Enrollment.enroll_id) AS enrollments_count,
        COUNT(DISTINCT Assignment.assignment_id) AS assignments_count
        FROM Course
        JOIN Professor ON Course.professor_id = Professor.professor_id
        LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
        LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
        WHERE Course.course_id = :id
            AND Course.professor_id = :professor_id
        GROUP BY Course.course_id, Course.course_name, Professor.professor_name
        ', [
    'id' => $course_id,
    'professor_id' => $professor['professor_id'],
])->find();

if (!$course) {
    abort(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->query('DELETE hp FROM HousePoints hp
            JOIN Submission s ON hp.submission_id = s.submission_id
            JOIN Assignment a ON s.assign_id = a.assignment_id
            WHERE a.course_id = :id
        ', [
        'id' => $course_id,
    ]);

    $db->query('DELETE FROM Course WHERE course_id = :id', [
        'id' => $course_id,
    ]);

    redirect('/dashboard');
}

return view('Dashboard/delete-course', [
    'course' => $course,
]);
