<?php

use Core\App;

$db = App::resolve('Core\Database');

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignment = $db->query('SELECT
        assignment_id,
        course_id,
        assignment_type,
        title,
        max_points,
        deadline
        FROM Assignment
        WHERE assignment_id = :id
        ', ['id' => $assignment_id])->find();

if (!$assignment) {
    abort(404);
}

$courses = $db->query('SELECT course_id, course_name FROM Course ORDER BY course_name')->get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $course_id = $_POST['course_id'] ?? '';
    $assignment_type = $_POST['assignment_type'] ?? '';
    $max_points = (int) ($_POST['max_points'] ?? 100);
    $deadline = $_POST['deadline'] ?? '';

    if (!$title || !$course_id || !in_array($assignment_type, ['Quiz', 'Task'], true) || !$deadline || $max_points < 1) {
        redirect('/edit-assignment?id=' . $assignment_id);
    }

    $course = $db->query('SELECT course_id FROM Course WHERE course_id = :id', [
        'id' => $course_id,
    ])->find();

    if (!$course) {
        redirect('/edit-assignment?id=' . $assignment_id);
    }

    $deadline = str_replace('T', ' ', $deadline);
    if (strlen($deadline) === 16) {
        $deadline .= ':00';
    }

    $db->query('UPDATE Assignment
            SET course_id = :course_id,
                assignment_type = :assignment_type,
                title = :title,
                max_points = :max_points,
                deadline = :deadline
            WHERE assignment_id = :assignment_id
        ', [
        'course_id' => $course_id,
        'assignment_type' => $assignment_type,
        'title' => $title,
        'max_points' => $max_points,
        'deadline' => $deadline,
        'assignment_id' => $assignment_id,
    ]);

    redirect('/show-assignment?id=' . $assignment_id);
}

return view('Dashboard/edit-assignment.view.php', [
    'assignment' => $assignment,
    'courses' => $courses,
]);
