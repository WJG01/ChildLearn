<?php
include "admin-session.php";
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-homepage.css">
    <link rel="icon" type="image/png" href="Images/Learneasy_favicon.png">
    <title>Admin Homepage</title>
</head>
<body>
   <?php include("admin-nav.php")?>

   <div class="homepage-container">
   <!--Welcome Messages and Display Admin Name-->
   <p class="admin-display-name">Welcome Back,
        <b><?php echo $_SESSION['adm_username']; ?></b>
   </p>

    <div class="statistics-box">
        <div class="first-row-stat-box">
            <?php 
                $student = "SELECT COUNT(*) AS totalstudents FROM student";
                $result = mysqli_query($conn, $student);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="student-stat">
                <p>Total Students</p>
                <hr class="lines">
                <h2><?php echo $row['totalstudents']; ?></h2>
            </div>
            <?php 
                $teacher = "SELECT COUNT(*) AS totalteacher FROM teacher";
                $result = mysqli_query($conn, $teacher);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="teacher-stat">
                <p>Total Teachers</p>
                <hr class="lines">
                <h2><?php echo $row['totalteacher']; ?></h2>
            </div>
            <?php 
                $teacher = "SELECT COUNT(*) AS totaladmin FROM admin";
                $result = mysqli_query($conn, $teacher);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="user-stat">
                <p>Total Admins</p>
                <hr class="lines">
                <h2><?php echo $row['totaladmin']; ?></h2>
            </div>
        </div>
        <div class ="second-row-stat-box">
            <?php 
                $course = "SELECT COUNT(*) AS pendingteacher FROM teacher WHERE teac_status = 'Not Verified'";
                $result = mysqli_query($conn, $course);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="course-stat">
                <p>Pending T.Approval</p>
                <hr class="lines">
                <h2><?php echo $row['pendingteacher']; ?></h2>
            </div>
            <?php 
                $course = "SELECT COUNT(*) AS totalforum FROM question";
                $result = mysqli_query($conn, $course);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="forum-stat">
                <p>Total Forum</p>
                <hr class="lines">
                <h2><?php echo $row['totalforum']; ?></h2>
            </div>
            <?php 
                $quiz = "SELECT COUNT(*) AS totalquiz FROM quiz";
                $result = mysqli_query($conn, $quiz);
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="quizzes-stat">
                <p>Total Quizzes</p>
                <hr class="lines">
                <h2><?php echo $row['totalquiz']; ?></h2>
            </div>   
        </div>
    </div>

    <div class="category-course">
        <p>Quizzes by Category:</p>
            <?php 
                $language = "SELECT COUNT(*) AS language FROM quiz WHERE quiz_category = 'Language and Literacy'";
                $result = mysqli_query($conn, $language);
                $row = mysqli_fetch_assoc($result);
            ?>
        <div class="language-cat">
            <h2>Language and Literacy: <b><?php echo $row['language']; ?> quizzes</b></h2>
        </div>
            <?php 
                $mathematic = "SELECT COUNT(*) AS mathematic FROM quiz WHERE quiz_category = 'Mathematics and Logic'";
                $result = mysqli_query($conn, $mathematic);
                $row = mysqli_fetch_assoc($result);
            ?>
        <div class="mathematic-cat">
            <h2>Mathematics and Logic: <b><?php echo $row['mathematic']; ?> quizzes</b></h2>
        </div>
            <?php 
                $Science_and_Discovery = "SELECT COUNT(*) AS Science and Discovery FROM quiz WHERE quiz_category = 'Science and Discovery'";
                $result = mysqli_query($conn, $Science_and_Discovery);
                $row = mysqli_fetch_assoc($result);
            ?>
        <div class="Science and Discovery-cat">
            <h2>Science and Discovery: <b><?php echo $row['Science and Discovery']; ?> quizzes</b></h2>
        </div>
    </div>
   </div>

   <div class="admin-footer">
        <div class="foo-des">
            <p>Mathematics and Logic and Develop by Win Yip & Jordan - FWDD Assignment</p>
        </div>
    </div>
</body>
</html> 