<?php

// $router->get('URI', 'CONTROLLER');;
// $router->get('uri', 'controller')->only('auth');
// $router->post('uri', 'controller')->only('guest');
// $router->patch('uri', 'controller');
// $router->delete('uri', 'controller')->only('auth');



$router->get('/', 'HomeController.php');
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/login', 'session/store.php')->only('guest');
$router->get('/leaderboard', 'leaderboard/LeaderboardController.php');
$router->get('/logout', 'session/destroy.php')->only('auth');
$router->delete('/logout', 'session/destroy.php')->only('auth');
$router->get('/student-panel', 'StudentPanelController.php')->only('auth');
$router->post('/enroll-course', 'StoreEnrollmentController.php')->only('auth');
$router->get('/professor-panel', 'ProfessorPanelController.php')->only('professor');


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
