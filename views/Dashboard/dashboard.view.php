<?php
include(base_path('views/partials/header.view.php'));
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
      <a href="#leaderboard" class="sidebar-link" data-section="leaderboard">
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
        <button class="btn btn-bronze">Go home</button>
        <button class="btn btn-bronze">Logout</button>
      </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
      <!-- Dashboard Overview Section -->
      <section id="dashboard-section" class="dashboard-section active">
        <h3 class="section-title">Dashboard Overview</h3>
        <p class="section-date">Current term: April 2025</p>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon enrolled">23</div>
            <p class="stat-label">Enrolled Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon courses">8</div>
            <p class="stat-label">Active Courses</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon quizzes">23</div>
            <p class="stat-label">Available Quizzes</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon points">529</div>
            <p class="stat-label">Total House Points</p>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <button class="btn btn-submit" onclick="showSection('students')">
            <i class="fa-solid fa-users"></i> Manage Students
          </button>
          <button class="btn btn-submit" onclick="showSection('professors')">
            <i class="fa-solid fa-chalkboard-user"></i> Manage Professors
          </button>
          <button class="btn btn-submit" onclick="showSection('courses')">
            <i class="fa-solid fa-book"></i> Manage Courses
          </button>
          <button class="btn btn-submit" onclick="showSection('quizzes')">
            <i class="fa-solid fa-question"></i> Manage Quizzes
          </button>
          <button class="btn btn-submit" onclick="showSection('assignments')">
            <i class="fa-solid fa-tasks"></i> Manage Assignments
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
            <div class="stat-icon enrolled">23</div>
            <p class="stat-label">Total Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon active">21</div>
            <p class="stat-label">Active Students</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon gryffindor">8</div>
            <p class="stat-label">Gryffindor</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon slytherin">6</div>
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
              <tr>
                <td>#1</td>
                <td>Harry James Potter</td>
                <td>harry@gryffindor.edu</td>
                <td><span class="house-badge gryffindor">Gryffindor</span></td>
                <td>666,666.00</td>
                <td>Holly - Phoenix Feather</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Deactivate</button>
                </td>
              </tr>
              <tr>
                <td>#2</td>
                <td>Hermione Jean Granger</td>
                <td>hermione@gryffindor.edu</td>
                <td><span class="house-badge gryffindor">Gryffindor</span></td>
                <td>550.00</td>
                <td>Vine - Dragon Heartstring</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Deactivate</button>
                </td>
              </tr>
              <tr>
                <td>#3</td>
                <td>Draco Lucius Malfoy</td>
                <td>draco@slytherin.edu</td>
                <td><span class="house-badge slytherin">Slytherin</span></td>
                <td>1,000.00</td>
                <td>Hawthorn - Unicorn Hair</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Deactivate</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Enroll New Student Form -->
        <div class="form-section">
          <h4 class="form-title">
            <i class="fa-solid fa-user-plus"></i> Enroll New Student
          </h4>
          <form class="enroll-form">
            <div class="form-row">
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" placeholder="Enter full name">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label>House</label>
                <select class="form-control">
                  <option>Gryffindor</option>
                  <option>Slytherin</option>
                  <option>Ravenclaw</option>
                  <option>Hufflepuff</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Enter password">
              </div>
              <div class="form-group">
                <label>Initial Balance</label>
                <input type="number" class="form-control" placeholder="1000.00" value="1000.00">
              </div>
              <div class="form-group">
                <label>Wand Wood</label>
                <select class="form-control">
                  <option>Holly</option>
                  <option>Yew</option>
                  <option>Elder</option>
                  <option>Willow</option>
                  <option>Hawthorn</option>
                  <option>Oak</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Wand Core</label>
                <select class="form-control">
                  <option>Phoenix Feather</option>
                  <option>Dragon Heartstring</option>
                  <option>Unicorn Hair</option>
                  <option>Thestral Tail Hair</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-submit">
              <i class="fa-solid fa-plus"></i> Enroll Student
            </button>
          </form>
        </div>
      </section>

      <!-- Professors Management Section -->
      <section id="professors-section" class="dashboard-section">
        <h3 class="section-title">
          <i class="fa-solid fa-chalkboard-user"></i> Professors Management
        </h3>

        <!-- Professor Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon professors">12</div>
            <p class="stat-label">Total Professors</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon active">12</div>
            <p class="stat-label">Active Professors</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon courses">8</div>
            <p class="stat-label">Courses Teaching</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon quizzes">23</div>
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
              <tr>
                <td>#1</td>
                <td>Prof. Albus Dumbledore</td>
                <td>dumbledore@hogwarts.edu</td>
                <td>3</td>
                <td>45</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Remove</button>
                </td>
              </tr>
              <tr>
                <td>#2</td>
                <td>Prof. Severus Snape</td>
                <td>snape@hogwarts.edu</td>
                <td>2</td>
                <td>28</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Remove</button>
                </td>
              </tr>
              <tr>
                <td>#3</td>
                <td>Prof. Minerva McGonagall</td>
                <td>mcgonagall@hogwarts.edu</td>
                <td>2</td>
                <td>32</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Remove</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Add New Professor Form -->
        <div class="form-section">
          <h4 class="form-title">
            <i class="fa-solid fa-user-plus"></i> Add New Professor
          </h4>
          <form class="enroll-form">
            <div class="form-row">
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" placeholder="Enter professor name">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Enter password">
              </div>
            </div>
            <button type="submit" class="btn btn-submit">
              <i class="fa-solid fa-plus"></i> Add Professor
            </button>
          </form>
        </div>
      </section>

      <!-- Courses Management Section -->
      <section id="courses-section" class="dashboard-section">
        <h3 class="section-title">
          <i class="fa-solid fa-book"></i> Courses Management
        </h3>

        <!-- Course Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon courses">8</div>
            <p class="stat-label">Total Courses</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon active">8</div>
            <p class="stat-label">Active Courses</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon enrolled">156</div>
            <p class="stat-label">Total Enrollments</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon quizzes">23</div>
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
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#1</td>
                <td>Defense Against the Dark Arts</td>
                <td>Prof. Severus Snape</td>
                <td>28</td>
                <td>5</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Archive</button>
                </td>
              </tr>
              <tr>
                <td>#2</td>
                <td>Transfiguration</td>
                <td>Prof. Minerva McGonagall</td>
                <td>32</td>
                <td>4</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Archive</button>
                </td>
              </tr>
              <tr>
                <td>#3</td>
                <td>Herbology</td>
                <td>Prof. Pomona Sprout</td>
                <td>25</td>
                <td>3</td>
                <td><span class="badge active">Active</span></td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Archive</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Add New Course Form -->
        <div class="form-section">
          <h4 class="form-title">
            <i class="fa-solid fa-plus"></i> Add New Course
          </h4>
          <form class="enroll-form">
            <div class="form-row">
              <div class="form-group">
                <label>Course Name</label>
                <input type="text" class="form-control" placeholder="Enter course name">
              </div>
              <div class="form-group">
                <label>Professor</label>
                <select class="form-control">
                  <option>Prof. Severus Snape</option>
                  <option>Prof. Minerva McGonagall</option>
                  <option>Prof. Pomona Sprout</option>
                  <option>Prof. Filius Flitwick</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-submit">
              <i class="fa-solid fa-plus"></i> Add Course
            </button>
          </form>
        </div>
      </section>

      <!-- Quizzes Management Section -->
      <section id="quizzes-section" class="dashboard-section">
        <h3 class="section-title">
          <i class="fa-solid fa-question"></i> Quizzes Management
        </h3>

        <!-- Quiz Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon quizzes">23</div>
            <p class="stat-label">Total Quizzes</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon active">18</div>
            <p class="stat-label">Active Quizzes</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon submissions">156</div>
            <p class="stat-label">Total Submissions</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon points">2,340</div>
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
              <tr>
                <td>#1</td>
                <td>Basic Defense Spells</td>
                <td>Defense Against the Dark Arts</td>
                <td>Prof. Snape</td>
                <td>100</td>
                <td>2025-05-15</td>
                <td>28/28</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
              <tr>
                <td>#2</td>
                <td>Transfiguration Theory</td>
                <td>Transfiguration</td>
                <td>Prof. McGonagall</td>
                <td>100</td>
                <td>2025-05-20</td>
                <td>30/32</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
              <tr>
                <td>#3</td>
                <td>Magical Herbs Quiz</td>
                <td>Herbology</td>
                <td>Prof. Sprout</td>
                <td>50</td>
                <td>2025-05-10</td>
                <td>25/25</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Add New Quiz Form -->
        <div class="form-section">
          <h4 class="form-title">
            <i class="fa-solid fa-plus"></i> Create New Quiz
          </h4>
          <form class="enroll-form">
            <div class="form-row">
              <div class="form-group">
                <label>Quiz Title</label>
                <input type="text" class="form-control" placeholder="Enter quiz title">
              </div>
              <div class="form-group">
                <label>Course</label>
                <select class="form-control">
                  <option>Defense Against the Dark Arts</option>
                  <option>Transfiguration</option>
                  <option>Herbology</option>
                  <option>Potions</option>
                </select>
              </div>
              <div class="form-group">
                <label>Max Points</label>
                <input type="number" class="form-control" placeholder="100" value="100">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" class="form-control">
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
      </section>

      <!-- Assignments Management Section -->
      <section id="assignments-section" class="dashboard-section">
        <h3 class="section-title">
          <i class="fa-solid fa-tasks"></i> Assignments Management
        </h3>

        <!-- Assignment Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon quizzes">45</div>
            <p class="stat-label">Total Assignments</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon active">28</div>
            <p class="stat-label">Quizzes</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon submissions">17</div>
            <p class="stat-label">Tasks</p>
          </div>
          <div class="stat-card">
            <div class="stat-icon points">8</div>
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#1001</td>
                <td>Brewing Basics Quiz</td>
                <td><span class="badge badge-quiz">Quiz</span></td>
                <td>Potions 101</td>
                <td>100</td>
                <td>2025-05-15</td>
                <td>2025-05-01</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
              <tr>
                <td>#1002</td>
                <td>Matchstick to Needle</td>
                <td><span class="badge badge-task">Task</span></td>
                <td>Transfiguration 301</td>
                <td>50</td>
                <td>2025-05-20</td>
                <td>2025-05-02</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
              <tr>
                <td>#1003</td>
                <td>Defense Spells Quiz</td>
                <td><span class="badge badge-quiz">Quiz</span></td>
                <td>Defense Against Dark Arts</td>
                <td>100</td>
                <td>2025-05-18</td>
                <td>2025-05-03</td>
                <td>
                  <button class="btn-action show">View</button>
                  <button class="btn-action edit">Edit</button>
                  <button class="btn-action delete">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Create New Assignment Form -->
        <div class="form-section">
          <h4 class="form-title">
            <i class="fa-solid fa-plus"></i> Create New Assignment
          </h4>
          <form class="enroll-form">
            <div class="form-row">
              <div class="form-group">
                <label>Assignment Title</label>
                <input type="text" class="form-control" placeholder="Enter assignment title" required>
              </div>
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" required>
                  <option value="">Select Type...</option>
                  <option value="Quiz">Quiz</option>
                  <option value="Task">Task</option>
                </select>
              </div>
              <div class="form-group">
                <label>Course</label>
                <select class="form-control" required>
                  <option>Potions 101</option>
                  <option>Transfiguration 301</option>
                  <option>Defense Against Dark Arts</option>
                  <option>Charms 201</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Max Points</label>
                <input type="number" class="form-control" placeholder="100" value="100" min="1" required>
              </div>
              <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" class="form-control" required>
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
      </section>

      <!-- Leaderboard Section -->
      <section id="leaderboard-section" class="dashboard-section">
        <h3 class="section-title">
          <i class="fa-solid fa-trophy"></i> House Leaderboard
        </h3>

        <!-- House Points Overview -->
        <div class="leaderboard-overview">
          <div class="house-leaderboard">
            <div class="house-card gryffindor">
              <div class="house-header">
                <h4>Gryffindor</h4>
                <div class="house-points">1,245 pts</div>
              </div>
              <div class="house-badge-large">🏆</div>
              <!-- <div class="house-rank">#1</div> -->
            </div>
            <div class="house-card slytherin">
              <div class="house-header">
                <h4>Slytherin</h4>
                <div class="house-points">1,180 pts</div>
              </div>
              <div class="house-badge-large">🥈</div>
              <!-- <div class="house-rank">#2</div> -->
            </div>
            <div class="house-card ravenclaw">
              <div class="house-header">
                <h4>Ravenclaw</h4>
                <div class="house-points">1,050 pts</div>
              </div>
              <div class="house-badge-large">🥉</div>
              <!-- <div class="house-rank">#3</div> -->
            </div>
            <div class="house-card hufflepuff">
              <div class="house-header">
                <h4>Hufflepuff</h4>
                <div class="house-points">980 pts</div>
              </div>
              <div class="house-badge-large">4️⃣</div>
              <!-- <div class="house-rank">#4</div> -->
            </div>
          </div>
        </div>

        <!-- Top Students Leaderboard -->
        <h4 class="subsection-title">Top Students</h4>
        <div class="table-container">
          <table class="dashboard-table">
            <thead>
              <tr>
                <th>Rank</th>
                <th>Student</th>
                <th>House</th>
                <th>Total Points</th>
                <th>Quizzes Completed</th>
                <th>Average Score</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="rank-badge gold">1</span></td>
                <td>Harry James Potter</td>
                <td><span class="house-badge gryffindor">Gryffindor</span></td>
                <td>450</td>
                <td>15</td>
                <td>95%</td>
              </tr>
              <tr>
                <td><span class="rank-badge silver">2</span></td>
                <td>Hermione Jean Granger</td>
                <td><span class="house-badge gryffindor">Gryffindor</span></td>
                <td>420</td>
                <td>15</td>
                <td>98%</td>
              </tr>
              <tr>
                <td><span class="rank-badge bronze">3</span></td>
                <td>Draco Lucius Malfoy</td>
                <td><span class="house-badge slytherin">Slytherin</span></td>
                <td>380</td>
                <td>14</td>
                <td>92%</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Luna Lovegood</td>
                <td><span class="house-badge ravenclaw">Ravenclaw</span></td>
                <td>350</td>
                <td>13</td>
                <td>88%</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Neville Longbottom</td>
                <td><span class="house-badge gryffindor">Gryffindor</span></td>
                <td>320</td>
                <td>12</td>
                <td>85%</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Recent Points Activity -->
        <h4 class="subsection-title">Recent Points Activity</h4>
        <div class="activity-feed">
          <div class="activity-item">
            <div class="activity-icon points">
              <i class="fa-solid fa-plus"></i>
            </div>
            <div class="activity-content">
              <p><strong>Harry Potter</strong> earned 25 points for excellent Defense Against the Dark Arts quiz</p>
              <span class="activity-time">2 hours ago</span>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-icon points">
              <i class="fa-solid fa-plus"></i>
            </div>
            <div class="activity-content">
              <p><strong>Gryffindor</strong> gained 50 house points for winning the Quidditch match</p>
              <span class="activity-time">1 day ago</span>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-icon points">
              <i class="fa-solid fa-plus"></i>
            </div>
            <div class="activity-content">
              <p><strong>Hermione Granger</strong> earned 30 points for outstanding Transfiguration assignment</p>
              <span class="activity-time">2 days ago</span>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
function showSection(sectionName) {
  // Hide all sections
  const sections = document.querySelectorAll('.dashboard-section');
  sections.forEach(section => section.classList.remove('active'));

  // Remove active class from sidebar links
  const sidebarLinks = document.querySelectorAll('.sidebar-link');
  sidebarLinks.forEach(link => link.classList.remove('active'));

  // Show selected section
  const targetSection = document.getElementById(sectionName + '-section');
  if (targetSection) {
    targetSection.classList.add('active');
  }

  // Activate corresponding sidebar link
  const targetLink = document.querySelector(`[data-section="${sectionName}"]`);
  if (targetLink) {
    targetLink.classList.add('active');
  }

  // Update page title
  const titles = {
    'dashboard': 'Dashboard Overview',
    'students': 'Students Management',
    'professors': 'Professors Management',
    'courses': 'Courses Management',
    'quizzes': 'Quizzes Management',
    'assignments': 'Assignments Management',
    'leaderboard': 'House Leaderboard'
  };
  document.getElementById('page-title').textContent = titles[sectionName] || 'Dashboard';
}

// Add click handlers to sidebar links
document.addEventListener('DOMContentLoaded', function() {
  const sidebarLinks = document.querySelectorAll('.sidebar-link');
  sidebarLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const section = this.getAttribute('data-section');
      showSection(section);
    });
  });
});
</script>

<?php 
include(base_path('views/partials/footer.view.php'));
?>
