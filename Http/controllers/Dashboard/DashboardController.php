<?php
// Database connection

use Core\App;

$db = App::resolve('Core\Database');

// Get all Students
$Students = $db->query('SELECT 
        Student.student_id, 
        User.user_name, 
        User.email AS user_email,
        House.house_name AS house,
        Student.balance,
        Student.status,
        CONCAT(Wand.wood_type, " - " , Wand.core_type) AS wand  
                FROM Student
                JOIN User ON Student.user_id = User.user_id
                JOIN House ON Student.house_id = House.house_id
        LEFT JOIN Wand ON Student.student_id = Wand.student_id
        ORDER BY Student.student_id DESC
        ')->get();

// Get all Professors
$Professors = $db->query('SELECT 
        Professor.professor_id,
        User.user_name,
        User.email,
        Professor.professor_name,
        COUNT(DISTINCT Course.course_id) AS courses_count,
        COUNT(DISTINCT Enrollment.student_id) AS students_count
        FROM Professor
        JOIN User ON Professor.user_id = User.user_id
        LEFT JOIN Course ON Professor.professor_id = Course.professor_id
        LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
        GROUP BY Professor.professor_id, User.user_name, User.email, Professor.professor_name
        ORDER BY Professor.professor_id DESC
        ')->get();

// Get all Courses
$Courses = $db->query('SELECT 
        Course.course_id,
        Course.course_name,
        Professor.professor_name,
        User.user_name AS prof_user_name,
        COUNT(DISTINCT Enrollment.student_id) AS enrolled_count,
        COUNT(DISTINCT Assignment.assignment_id) AS assignments_count,
        COUNT(DISTINCT Submission.submission_id) AS submissions_count
        FROM Course
        JOIN Professor ON Course.professor_id = Professor.professor_id
        JOIN User ON Professor.user_id = User.user_id
        LEFT JOIN Enrollment ON Course.course_id = Enrollment.course_id
        LEFT JOIN Assignment ON Course.course_id = Assignment.course_id
        LEFT JOIN Submission ON Assignment.assignment_id = Submission.assign_id
        GROUP BY Course.course_id, Course.course_name, Professor.professor_name, User.user_name
        ORDER BY Course.course_id DESC
        ')->get();

// Get all Quizzes/Assignments
$Assignments = $db->query('SELECT 
        Assignment.assignment_id,
        Assignment.title,
        Assignment.assignment_type,
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
        GROUP BY Assignment.assignment_id, Assignment.title, Assignment.assignment_type, 
                 Course.course_name, Professor.professor_name, Assignment.max_points, 
                 Assignment.deadline, Assignment.created_at
        ORDER BY Assignment.created_at DESC
        ')->get();

$quizCount = (int) $db->query('SELECT COUNT(*) as count FROM Assignment WHERE assignment_type = "Quiz"')->find()['count'];
$taskCount = (int) $db->query('SELECT COUNT(*) as count FROM Assignment WHERE assignment_type = "Task"')->find()['count'];
$totalSubmissions = (int) $db->query('SELECT COUNT(*) as count FROM Submission')->find()['count'];
$pointsAwarded = (int) ($db->query('SELECT SUM(points) as total FROM HousePoints')->find()['total'] ?? 0);

// Get Dashboard Stats
$stats = [
    'total_students' => (int) $db->query('SELECT COUNT(*) as count FROM Student')->find()['count'],
    'active_students' => (int) $db->query('SELECT COUNT(*) as count FROM Student WHERE status = "Active"')->find()['count'],
    'inactive_students' => (int) $db->query('SELECT COUNT(*) as count FROM Student WHERE status = "Inactive"')->find()['count'],
    'total_professors' => (int) $db->query('SELECT COUNT(*) as count FROM Professor')->find()['count'],
    'total_courses' => (int) $db->query('SELECT COUNT(*) as count FROM Course')->find()['count'],
    'total_enrollments' => (int) $db->query('SELECT COUNT(*) as count FROM Enrollment WHERE status = "Enrolled"')->find()['count'],
    'total_assignments' => (int) $db->query('SELECT COUNT(*) as count FROM Assignment')->find()['count'],
    'total_quizzes' => $quizCount,
    'total_tasks' => $taskCount,
    'active_quizzes' => (int) $db->query('SELECT COUNT(*) as count FROM Assignment WHERE assignment_type = "Quiz" AND deadline >= NOW()')->find()['count'],
    'upcoming_deadlines' => (int) $db->query('SELECT COUNT(*) as count FROM Assignment WHERE deadline >= NOW()')->find()['count'],
    'total_submissions' => $totalSubmissions,
    'points_awarded' => $pointsAwarded,
    'house_points' => (int) ($db->query('SELECT SUM(total_points) as total FROM House')->find()['total'] ?? 0),
];

$houseStats = $db->query('SELECT house_name, COUNT(Student.student_id) AS students_count, total_points
        FROM House
        LEFT JOIN Student ON House.house_id = Student.house_id
        GROUP BY House.house_id, House.house_name, House.total_points
        ORDER BY House.house_name
        ')->get();

return view('Dashboard/dashboard.view.php', [
    'Students' => $Students,
    'Professors' => $Professors,
    'Courses' => $Courses,
    'Assignments' => $Assignments,
    'stats' => $stats,
    'houseStats' => $houseStats,
]);
