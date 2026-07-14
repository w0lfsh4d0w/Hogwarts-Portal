<?php
use Http\Models\QuizModel;

$user = \Core\JwtService::verify(\Core\JwtService::getTokenFromCookie());
$studentId = $user['student_id'] ?? null;
$assignmentId = $_GET['id'] ?? null;

if (!$studentId || !$assignmentId) abort(404);

$quizModel = new QuizModel();
$assignment = $quizModel->getAssignmentById($assignmentId, $studentId);

if (!$assignment) {
    redirect('/my-classrooms');
}

// Ensure the deadline hasn't passed
if (strtotime($assignment['deadline']) < time()) {
    redirect('/my-classrooms'); 
}

view('student/activeQuiz', [
    'assignment' => $assignment
]);