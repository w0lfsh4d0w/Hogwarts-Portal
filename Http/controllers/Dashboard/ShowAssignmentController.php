<?php

use Core\App;

$db = App::resolve('Core\Database');

$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) {
    abort(400);
}

$assignment = $db->query('SELECT 
        Assignment.assignment_id,
        Assignment.title,
        Assignment.assignment_type,
        Course.course_id,
        Course.course_name,
        Professor.professor_name,
        Assignment.max_points,
        Assignment.deadline,
        Assignment.created_at,
        COUNT(DISTINCT Submission.submission_id) AS submission_count
        FROM Assignment
        JOIN Course ON Assignment.course_id = Course.course_id
        JOIN Professor ON Course.professor_id = Professor.professor_id
        LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
        WHERE Assignment.assignment_id = :id
        GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type, 
                 Course.course_id, Course.course_name, Professor.professor_name, 
                 Assignment.max_points, Assignment.deadline, Assignment.created_at
        ', ['id' => $assignment_id])->find();

if (!$assignment) {
    abort(404);
}

$submissions = $db->query('SELECT 
        Submission.submission_id,
        User.user_name,
        Submission.score,
        Submission.submitted_at
        FROM Submission
        JOIN Student ON Submission.student_id = Student.student_id
        JOIN User ON Student.user_id = User.user_id
        WHERE Submission.assign_id = :id
        ORDER BY Submission.submitted_at DESC
        ', ['id' => $assignment_id])->get();

return view('Dashboard/show-assignment.view.php', [
    'assignment' => $assignment,
    'submissions' => $submissions,
]);
