<?php

use Core\App;

$db = App::resolve('Core\Database');

// Houses مرتبة من الأعلى
$houses = $db->query(
    "SELECT house_name, total_points
     FROM House
     ORDER BY total_points DESC"
)->get();

// Top 10 Students
$students = $db->query(
    "SELECT
        u.user_name                           AS name,
        h.house_name                          AS house,
        COALESCE(SUM(hp.points), 0)           AS total_points,
        COUNT(DISTINCT sub.submission_id)     AS quizzes_completed,
        COALESCE(ROUND(AVG(sub.score), 0), 0) AS avg_score
     FROM Student st
     JOIN User u              ON u.user_id        = st.user_id
     JOIN House h             ON h.house_id       = st.house_id
     LEFT JOIN Submission sub ON sub.student_id   = st.student_id
     LEFT JOIN HousePoints hp ON hp.student_id    = st.student_id
     GROUP BY st.student_id, u.user_name, h.house_name
     ORDER BY total_points DESC
     LIMIT 10"
)->get();

view('leaderboard.view.php', [
    'houses'   => $houses,
    'students' => $students,
]);