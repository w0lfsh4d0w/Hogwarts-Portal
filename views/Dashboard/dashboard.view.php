<?php
include(base_path('views/partials/header.view.php'));

$houseStudentCounts = array_column($houseStats ?? [], 'students_count', 'house_name');
$canManageAcademic = is_professor();
$canCreateProfessor = is_dumbledore();
$dashboardActionVerb = $canManageAcademic ? 'Manage' : 'View';
?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Hogwarts</h3>
        </div>
        <nav class="sidebar-nav">
            <a href="#dashboard" class="sidebar-link active" data-section="dashboard">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="#students" class="sidebar-link" data-section="students">
                <i class="fa-solid fa-users"></i>
                <span>Students</span>
            </a>
            <a href="#professors" class="sidebar-link" data-section="professors">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Professors</span>
            </a>
            <a href="#courses" class="sidebar-link" data-section="courses">
                <i class="fa-solid fa-book"></i>
                <span>Courses</span>
            </a>
            <a href="#quizzes" class="sidebar-link" data-section="quizzes">
                <i class="fa-solid fa-question"></i>
                <span>Quizzes</span>
            </a>
            <a href="#assignments" class="sidebar-link" data-section="assignments">
                <i class="fa-solid fa-tasks"></i>
                <span>Assignments</span>
            </a>
            <a href="/leaderboard" class="sidebar-link">
                <i class="fa-solid fa-trophy"></i>
                <span>Leaderboard</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2 id="page-title">Dashboard Overview</h2>
            <div class="top-bar-actions">
                <a href="/" class="btn btn-bronze">Go home</a>
                <a href="/logout" class="btn btn-bronze">Logout</a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Overview Section -->
            <section id="dashboard-section" class="dashboard-section active">
                <h3 class="section-title">Dashboard Overview</h3>
                <p class="section-date">Current term: <?php echo date('F Y'); ?></p>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['active_students']; ?></div>
                        <p class="stat-label">Enrolled Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Active Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_quizzes']; ?></div>
                        <p class="stat-label">Available Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo number_format($stats['house_points']); ?></div>
                        <p class="stat-label">Total House Points</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <button class="btn btn-submit" onclick="showSection('students')">
                        <i class="fa-solid fa-users"></i> <?php echo $dashboardActionVerb; ?> Students
                    </button>
                    <button class="btn btn-submit" onclick="showSection('professors')">
                        <i class="fa-solid fa-chalkboard-user"></i> <?php echo $dashboardActionVerb; ?> Professors
                    </button>
                    <button class="btn btn-submit" onclick="showSection('courses')">
                        <i class="fa-solid fa-book"></i> <?php echo $dashboardActionVerb; ?> Courses
                    </button>
                    <button class="btn btn-submit" onclick="showSection('quizzes')">
                        <i class="fa-solid fa-question"></i> <?php echo $dashboardActionVerb; ?> Quizzes
                    </button>
                    <button class="btn btn-submit" onclick="showSection('assignments')">
                        <i class="fa-solid fa-tasks"></i> <?php echo $dashboardActionVerb; ?> Assignments
                    </button>
                </div>
            </section>

            <!-- Students Management Section -->
            <section id="students-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-users"></i> Students Management
                </h3>

                <!-- Student Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['total_students']; ?></div>
                        <p class="stat-label">Total Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['active_students']; ?></div>
                        <p class="stat-label">Active Students</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon gryffindor"><?php echo $houseStudentCounts['Gryffindor'] ?? 0; ?></div>
                        <p class="stat-label">Gryffindor</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon slytherin"><?php echo $houseStudentCounts['Slytherin'] ?? 0; ?></div>
                        <p class="stat-label">Slytherin</p>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>House</th>
                                <th>Balance</th>
                                <th>Wand</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Students as $std): ?>
                                <tr>
                                    <td><?php echo $std['student_id']; ?></td>
                                    <td><?php echo $std['user_name']; ?></td>
                                    <td><?php echo $std['user_email']; ?></td>
                                    <td><span class="house-badge <?php echo strtolower($std['house']); ?>"><?php echo $std['house']; ?></span></td>
                                    <td><?php echo number_format($std['balance'], 2); ?></td>
                                    <td><?php echo $std['wand'] ?? 'Not assigned'; ?></td>
                                    <td><span class="badge <?php echo strtolower($std['status']); ?>"><?php echo $std['status']; ?></span></td>
                                    <td>
                                        <a href="/show-student?id=<?php echo $std['student_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-student?id=<?php echo $std['student_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-student?id=<?php echo $std['student_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canManageAcademic): ?>
                    <!-- Enroll New Student Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-user-plus"></i> Enroll New Student
                        </h4>
                        <form method="POST" action="/store-student" class="enroll-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="user_name" class="form-control" placeholder="Enter full name" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>House</label>
                                <select name="house" class="form-control" required>
                                    <option value="">Select House</option>
                                    <option value="Gryffindor">Gryffindor</option>
                                    <option value="Slytherin">Slytherin</option>
                                    <option value="Ravenclaw">Ravenclaw</option>
                                    <option value="Hufflepuff">Hufflepuff</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <div class="form-group">
                                <label>Initial Balance</label>
                                <input type="number" name="balance" step="0.01" class="form-control" placeholder="1000.00" value="1000.00" required>
                            </div>
                            <div class="form-group">
                                <label>Wand Wood</label>
                                <select name="wood_type" class="form-control" required>
                                    <option value="">Select Wood</option>
                                    <option value="Holly">Holly</option>
                                    <option value="Yew">Yew</option>
                                    <option value="Elder">Elder</option>
                                    <option value="Willow">Willow</option>
                                    <option value="Hawthorn">Hawthorn</option>
                                    <option value="Oak">Oak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Wand Core</label>
                                <select name="core_type" class="form-control" required>
                                    <option value="">Select Core</option>
                                    <option value="Phoenix Feather">Phoenix Feather</option>
                                    <option value="Dragon Heartstring">Dragon Heartstring</option>
                                    <option value="Unicorn Hair">Unicorn Hair</option>
                                    <option value="Thestral Tail Hair">Thestral Tail Hair</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Enroll Student
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Professors Management Section -->
            <section id="professors-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-chalkboard-user"></i> Professors Management
                </h3>

                <!-- Professor Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon professors"><?php echo $stats['total_professors']; ?></div>
                        <p class="stat-label">Total Professors</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['total_professors']; ?></div>
                        <p class="stat-label">Active Professors</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Courses Teaching</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_assignments']; ?></div>
                        <p class="stat-label">Quizzes Created</p>
                    </div>
                </div>

                <!-- Professors Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Students</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Professors as $prof): ?>
                                <tr>
                                    <td><?php echo $prof['professor_id']; ?></td>
                                    <td><?php echo $prof['professor_name']; ?></td>
                                    <td><?php echo $prof['email']; ?></td>
                                    <td><?php echo $prof['courses_count']; ?></td>
                                    <td><?php echo $prof['students_count']; ?></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>
                                        <a href="/show-professor?id=<?php echo $prof['professor_id']; ?>" class="btn-action show">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canCreateProfessor): ?>
                    <!-- Add New Professor Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-user-plus"></i> Add New Professor
                        </h4>
                        <form method="POST" action="/store-professor" class="enroll-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="user_name" class="form-control" placeholder="Enter professor name" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Professor Display Name</label>
                                <input type="text" name="professor_name" class="form-control" placeholder="Professor name" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Add Professor
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Courses Management Section -->
            <section id="courses-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-book"></i> Courses Management
                </h3>

                <!-- Course Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon courses"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Total Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['total_courses']; ?></div>
                        <p class="stat-label">Active Courses</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon enrolled"><?php echo $stats['total_enrollments']; ?></div>
                        <p class="stat-label">Total Enrollments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_assignments']; ?></div>
                        <p class="stat-label">Assignments</p>
                    </div>
                </div>

                <!-- Courses Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Professor</th>
                                <th>Enrolled Students</th>
                                <th>Assignments</th>
                                <th>Submissions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Courses as $course): ?>
                                <tr>
                                    <td><?php echo $course['course_id']; ?></td>
                                    <td><?php echo $course['course_name']; ?></td>
                                    <td><?php echo $course['professor_name']; ?></td>
                                    <td><?php echo $course['enrolled_count']; ?></td>
                                    <td><?php echo $course['assignments_count']; ?></td>
                                    <td><?php echo $course['submissions_count']; ?></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>
                                        <a href="/show-course?id=<?php echo $course['course_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-course?id=<?php echo $course['course_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-course?id=<?php echo $course['course_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canManageAcademic): ?>
                    <!-- Add New Course Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-plus"></i> Add New Course
                        </h4>
                        <form method="POST" action="/store-course" class="enroll-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Course Name</label>
                                <input type="text" name="course_name" class="form-control" placeholder="Enter course name" required>
                            </div>
                            <div class="form-group">
                                <label>Professor</label>
                                <input type="hidden" name="professor_id" value="<?php echo $currentProfessor['professor_id'] ?? ''; ?>">
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($currentProfessor['professor_name'] ?? 'Current Professor'); ?>" disabled>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Add Course
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Quizzes Management Section -->
            <section id="quizzes-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-question"></i> Quizzes Management
                </h3>

                <!-- Quiz Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_quizzes']; ?></div>
                        <p class="stat-label">Total Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['active_quizzes']; ?></div>
                        <p class="stat-label">Active Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['total_submissions']; ?></div>
                        <p class="stat-label">Total Submissions</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo number_format($stats['points_awarded']); ?></div>
                        <p class="stat-label">Points Awarded</p>
                    </div>
                </div>

                <!-- Quizzes Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Quiz Title</th>
                                <th>Course</th>
                                <th>Professor</th>
                                <th>Max Points</th>
                                <th>Deadline</th>
                                <th>Submissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Assignments as $assign): 
                                if ($assign['assignment_type'] === 'Quiz'): ?>
                                <tr>
                                    <td><?php echo $assign['assignment_id']; ?></td>
                                    <td><?php echo $assign['title']; ?></td>
                                    <td><?php echo $assign['course_name']; ?></td>
                                    <td><?php echo $assign['professor_name']; ?></td>
                                    <td><?php echo $assign['max_points']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($assign['deadline'])); ?></td>
	                                    <td><?php echo $assign['submission_count']; ?></td>
                                    <td>
                                        <a href="/show-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; 
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canManageAcademic): ?>
                    <!-- Add New Quiz Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-plus"></i> Create New Quiz
                        </h4>
                        <form method="POST" action="/store-assignment" class="enroll-form">
                        <input type="hidden" name="assignment_type" value="Quiz">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Quiz Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter quiz title" required>
                            </div>
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($Courses as $course): ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Max Points</label>
                                <input type="number" name="max_points" class="form-control" placeholder="100" value="100" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Deadline</label>
                                <input type="datetime-local" name="deadline" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Quiz description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Create Quiz
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Assignments Management Section -->
            <section id="assignments-section" class="dashboard-section">
                <h3 class="section-title">
                    <i class="fa-solid fa-tasks"></i> Assignments Management
                </h3>

                <!-- Assignment Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon quizzes"><?php echo $stats['total_assignments']; ?></div>
                        <p class="stat-label">Total Assignments</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active"><?php echo $stats['total_quizzes']; ?></div>
                        <p class="stat-label">Quizzes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['total_tasks']; ?></div>
                        <p class="stat-label">Tasks</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon submissions"><?php echo $stats['total_submissions']; ?></div>
                        <p class="stat-label">Total Submissions</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon points"><?php echo $stats['upcoming_deadlines']; ?></div>
                        <p class="stat-label">Upcoming Deadlines</p>
                    </div>
                </div>

                <!-- Assignments Table -->
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Course</th>
                                <th>Max Points</th>
                                <th>Deadline</th>
                                <th>Created</th>
                                <th>Submissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Assignments as $assign): ?>
                                <tr>
                                    <td><?php echo $assign['assignment_id']; ?></td>
                                    <td><?php echo $assign['title']; ?></td>
                                    <td><span class="badge badge-<?php echo strtolower($assign['assignment_type']); ?>"><?php echo $assign['assignment_type']; ?></span></td>
                                    <td><?php echo $assign['course_name']; ?></td>
                                    <td><?php echo $assign['max_points']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($assign['deadline'])); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($assign['created_at'])); ?></td>
                                    <td><?php echo $assign['submission_count']; ?></td>
                                    <td>
                                        <a href="/show-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action show">View</a>
                                        <?php if ($canManageAcademic): ?>
                                            <a href="/edit-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action edit">Edit</a>
                                            <a href="/delete-assignment?id=<?php echo $assign['assignment_id']; ?>" class="btn-action delete">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($canManageAcademic): ?>
                    <!-- Create New Assignment Form -->
                    <div class="form-section">
                        <h4 class="form-title">
                            <i class="fa-solid fa-plus"></i> Create New Assignment
                        </h4>
                        <form method="POST" action="/store-assignment" class="enroll-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Assignment Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter assignment title" required>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="assignment_type" class="form-control" required>
                                    <option value="">Select Type...</option>
                                    <option value="Quiz">Quiz</option>
                                    <option value="Task">Task</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($Courses as $course): ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Max Points</label>
                                <input type="number" name="max_points" class="form-control" placeholder="100" value="100" min="1"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Deadline</label>
                                <input type="datetime-local" name="deadline" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Assignment description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="fa-solid fa-plus"></i> Create Assignment
                        </button>
                        </form>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</div>

<script>
    function showSection(sectionName) {
        const sections = document.querySelectorAll('.dashboard-section');
        sections.forEach(section => section.classList.remove('active'));

        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => link.classList.remove('active'));

        const targetSection = document.getElementById(sectionName + '-section');
        if (targetSection) {
            targetSection.classList.add('active');
        }

        const targetLink = document.querySelector(`[data-section="${sectionName}"]`);
        if (targetLink) {
            targetLink.classList.add('active');
        }

        const titles = {
            'dashboard': 'Dashboard Overview',
            'students': 'Students Management',
            'professors': 'Professors Management',
            'courses': 'Courses Management',
            'quizzes': 'Quizzes Management',
            'assignments': 'Assignments Management'
        };
        document.getElementById('page-title').textContent = titles[sectionName] || 'Dashboard';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const section = this.getAttribute('data-section');
                if (!section) {
                    return;
                }
                e.preventDefault();
                showSection(section);
            });
        });

        const initialSection = window.location.hash.replace('#', '');
        if (initialSection) {
            showSection(initialSection);
        }
    });
</script>

<?php
include(base_path('views/partials/footer.view.php'));
?>
