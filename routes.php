<?php

// $router->get('URI', 'CONTROLLER');;
// $router->get('uri', 'controller')->only('auth');
// $router->post('uri', 'controller')->only('guest');
// $router->patch('uri', 'controller');
// $router->delete('uri', 'controller')->only('auth');



$router->get('/', 'HomeController.php');
$router->get('/leaderboard', 'Leaderboard/LeaderboardController.php');
$router->get('/logout', 'session/destroy.php');
$router->get('/student-panel', 'StudentPanelController.php')->only('auth');


// ================== Dashboard Routes ==================
$router->get('/dashboard', 'Dashboard/DashboardController.php')->only('dumbledore');
$router->get('/show-student', 'Dashboard/ShowStudentController.php')->only('dumbledore');
$router->get('/edit-student', 'Dashboard/EditStudentController.php')->only('dumbledore');
$router->post('/edit-student', 'Dashboard/EditStudentController.php')->only('dumbledore');
$router->get('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('dumbledore');
$router->post('/deactivate-student', 'Dashboard/DeactivateStudentController.php')->only('dumbledore');
$router->get('/delete-student', 'Dashboard/DeleteStudentController.php')->only('dumbledore');
$router->post('/delete-student', 'Dashboard/DeleteStudentController.php')->only('dumbledore');
$router->post('/store-student', 'Dashboard/StoreStudentController.php')->only('dumbledore');
$router->post('/store-professor', 'Dashboard/StoreProfessorController.php')->only('dumbledore');
$router->post('/store-course', 'Dashboard/StoreCourseController.php')->only('dumbledore');
$router->post('/store-assignment', 'Dashboard/StoreAssignmentController.php')->only('dumbledore');

// Professors Routes
$router->get('/show-professor', 'Dashboard/ShowProfessorController.php')->only('dumbledore');
$router->get('/edit-professor', 'Dashboard/EditProfessorController.php')->only('dumbledore');
$router->post('/edit-professor', 'Dashboard/EditProfessorController.php')->only('dumbledore');
$router->get('/delete-professor', 'Dashboard/DeleteProfessorController.php')->only('dumbledore');
$router->post('/delete-professor', 'Dashboard/DeleteProfessorController.php')->only('dumbledore');

// Courses Routes
$router->get('/show-course', 'Dashboard/ShowCourseController.php')->only('dumbledore');
$router->get('/edit-course', 'Dashboard/EditCourseController.php')->only('dumbledore');
$router->post('/edit-course', 'Dashboard/EditCourseController.php')->only('dumbledore');
$router->get('/delete-course', 'Dashboard/DeleteCourseController.php')->only('dumbledore');
$router->post('/delete-course', 'Dashboard/DeleteCourseController.php')->only('dumbledore');

// Assignments Routes
$router->get('/show-assignment', 'Dashboard/ShowAssignmentController.php')->only('dumbledore');
$router->get('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('dumbledore');
$router->post('/edit-assignment', 'Dashboard/EditAssignmentController.php')->only('dumbledore');
$router->get('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('dumbledore');
$router->post('/delete-assignment', 'Dashboard/DeleteAssignmentController.php')->only('dumbledore');
