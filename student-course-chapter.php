<?php
session_start();
include("config.php");

if (isset($_SESSION['id'])) {
    $nav = "student-navi.php";
} else {
    echo '<script>alert("You must log in to your account first.")</script>';
    echo '<script>location.href="index.php"</script>';
}
include($nav);

// Retrieve all chapters of the selected course from the course_chapter table
$course_id = $_GET['course_id'];


$sql = "SELECT course_title FROM course WHERE course_id = '$course_id'";
$course_result = mysqli_query($conn, $sql);
$course_row = mysqli_fetch_assoc($course_result);
$course_title = $course_row['course_title'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8e94eefdff.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
    <link rel="stylesheet" href="stylesheets/student-course-chapter.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/paginations.css">
    <title><?php echo $course_title ?> Course</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $course_title ?> Course</h1>
        <hr>
        <?php

        $chapter_query = "SELECT * FROM course_chapter WHERE course_id = '$course_id' ORDER BY chapter_order ASC";
        $chapter_result = mysqli_query($conn, $chapter_query);

        // Check if there are any chapters available
        if (mysqli_num_rows($chapter_result) > 0) {
            while ($chapter_row = mysqli_fetch_assoc($chapter_result)) {
                $chapter_title = $chapter_row['chapter_title'];
                $chapter_order = $chapter_row['chapter_order'];
        ?>

                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="mb-0">Chapter <?php echo $chapter_order ?>:</h2>
                    </div>
                    <div class="card-body slim-card-body">
                        <i class="bi bi-link-45deg">
                            <a href="student-chapter-details.php?chapter_id=<?php echo $chapter_row['chapter_id']; ?>">
                                <?php echo $chapter_title; ?>
                            </a>
                        </i>
                    </div>
                </div>

        <?php
            }
        } else {
            echo '<div class="alert alert-info">No chapters found for this course.</div>';
        }
        ?>

        <?php
        $quiz_query = "SELECT * FROM quiz WHERE course_id=? LIMIT 1";
        $stmt = $conn->prepare($quiz_query);
        $stmt->bind_param('s', $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quizCount = $result->num_rows;

        // Check if there is at least one quiz available
        if ($quizCount > 0) {
            $quiz_row = $result->fetch_assoc(); // Fetch the row
            $quiz_id = $quiz_row['quiz_id'];
            $quiz_title = $quiz_row['quiz_title'];
        ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h2 class="mb-0">Final Assessment :</h2>
                </div>
                <div class="card-body slim-card-body">
                    <i class="bi bi-link-45deg">
                        <a href="student-quizquestion.php?quizid=<?php echo $quiz_id; ?>" target="_blank">
                            <?php echo $quiz_title; ?>
                        </a>
                    </i>
                </div>
            </div>
        <?php
        } else {
            echo '<div class="alert alert-info">No quiz found for this course.</div>';
        }

        $stmt->close(); // Close the statement
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>