<?php

use Core\App;

$db = App::resolve('Core\Database');
$professor = require_current_professor($db);

$submissionId = $_POST['submission_id'] ?? null;
$assignmentId = $_POST['assignment_id'] ?? null;

if (!$submissionId || !$assignmentId) {
    redirect('/show-assignment?id=' . $assignmentId);
}

$submission = $db->query('SELECT Submission.submission_id FROM Submission
        JOIN Assignment ON Submission.assign_id = Assignment.assignment_id
        JOIN Course ON Assignment.course_id = Course.course_id
        WHERE Submission.submission_id = :submission_id
            AND Submission.assign_id = :assignment_id
            AND Course.professor_id = :professor_id
    ', [
    'submission_id' => $submissionId,
    'assignment_id' => $assignmentId,
    'professor_id' => $professor['professor_id'],
])->find();

if (!$submission) {
    abort(404);
}

$db->query('DELETE FROM HousePoints WHERE submission_id = :submission_id', [
    'submission_id' => $submissionId,
]);

$db->query('DELETE FROM Submission WHERE submission_id = :submission_id', [
    'submission_id' => $submissionId,
]);

redirect('/show-assignment?id=' . $assignmentId);
