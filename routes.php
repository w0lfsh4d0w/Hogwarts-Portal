<?php
// Home
$router->get('/', 'HomeController.php');

// Registration
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

// Session
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->get('/logout', 'session/destroy.php')->only('auth');
$router->delete('/logout', 'session/destroy.php')->only('auth');

// Student and professor panels
$router->get('/student-panel', 'StudentPanelController.php')->only('student');
$router->post('/enroll-course', 'StoreEnrollmentController.php')->only('student');
$router->get('/professor-panel', 'ProfessorPanelController.php')->only('professor');

// Shop and inventory
$router->get('/shop', 'shop/index.php')->only('student');
$router->post('/shop/buy', 'shop/store.php')->only('student');
$router->get('/inventory', 'inventory/index.php')->only('student');
$router->post('/inventory/remove', 'inventory/store.php')->only('student');

// Leaderboard
$router->get('/leaderboard', 'leaderboard/LeaderboardController.php');

// ================== Dashboard Routes ==================
$router->get('/dashboard', 'Dashboard/DashboardController.php')->only('staff');
$router->get('/show-student', 'Dashboard/ShowStudentController.php')->only('staff');
$router->get('/edit-student', 'Dashboard/EditStudentController.php')->only('professor');
$router->post('/edit-student', 'Dashboard/EditStudentController.php')->only('professor');
$router->get('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('professor');
$router->post('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('professor');
$router->get('/delete-student', 'Dashboard/DeleteStudentController.php')->only('professor');
$router->post('/delete-student', 'Dashboard/DeleteStudentController.php')->only('professor');
$router->post('/store-student', 'Dashboard/StoreStudentController.php')->only('professor');
$router->post('/store-professor', 'Dashboard/StoreProfessorController.php')->only('dumbledore');
$router->post('/store-course', 'Dashboard/StoreCourseController.php')->only('professor');
$router->post('/store-assignment', 'Dashboard/StoreAssignmentController.php')->only('professor');
$router->post('/store-score', 'Dashboard/StoreScoreController.php')->only('professor');
$router->post('/delete-score', 'Dashboard/DeleteScoreController.php')->only('professor');

// Professors Routes
$router->get('/show-professor', 'Dashboard/ShowProfessorController.php')->only('staff');

// Courses Routes
$router->get('/show-course', 'Dashboard/ShowCourseController.php')->only('staff');
$router->get('/edit-course', 'Dashboard/EditCourseController.php')->only('professor');
$router->post('/edit-course', 'Dashboard/EditCourseController.php')->only('professor');
$router->get('/delete-course', 'Dashboard/DeleteCourseController.php')->only('professor');
$router->post('/delete-course', 'Dashboard/DeleteCourseController.php')->only('professor');

// Assignments Routes
$router->get('/show-assignment', 'Dashboard/ShowAssignmentController.php')->only('staff');
$router->get('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('professor');
$router->post('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('professor');
$router->get('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('professor');
$router->post('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('professor');
