<?php
include(base_path('views/partials/header.view.php'));
?>

<div class="dashboard-container">
    <div class="main-content">
        <div class="top-bar">
            <h2 id="page-title">Course Details</h2>
            <div class="top-bar-actions">
                <a href="/dashboard" class="btn btn-bronze">Back to Dashboard</a>
            </div>
        </div>

        <div class="dashboard-content">
            <section class="dashboard-section active">
                <h3 class="section-title">Course Information</h3>

                <div class="student-details">
                    <div class="detail-row">
                        <label>Course ID:</label>
                        <span><?php echo $course['course_id']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Course Name:</label>
                        <span><?php echo $course['course_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Professor:</label>
                        <span><?php echo $course['professor_name']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Enrolled Students:</label>
                        <span><?php echo $course['enrolled_count']; ?></span>
                    </div>
                    <div class="detail-row">
                        <label>Total Assignments:</label>
                        <span><?php echo $course['assignments_count']; ?></span>
                    </div>
                </div>

                <div class="action-buttons" style="margin-top: 30px;">
                    <a href="/edit-course?id=<?php echo $course['course_id']; ?>" class="btn btn-submit">
                        <i class="fa-solid fa-edit"></i> Edit Course
                    </a>
                    <a href="/delete-course?id=<?php echo $course['course_id']; ?>" class="btn btn-danger" style="background-color: #d32f2f; margin-left: 10px;">
                        <i class="fa-solid fa-trash"></i> Delete Course
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
include(base_path('views/partials/footer.view.php'));
?>
