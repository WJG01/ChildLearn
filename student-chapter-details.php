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

// Get the chapter_id from the query string
$chapter_id = $_GET['chapter_id'];

// Retrieve the chapter title from the course_chapter table
$sql = "SELECT chapter_title, content_text, content_image, content_video FROM course_chapter WHERE chapter_id = '$chapter_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$chapter_title = $row['chapter_title'];
$content_text = $row['content_text'];
$content_image = $row['content_image'];
$content_video = $row['content_video'];
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
    <link rel="stylesheet" href="stylesheets/student-chapter-details.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/paginations.css">
    <title>Chapter: <?php echo $chapter_title ?> </title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chapter: <?php echo $chapter_title; ?></h2>
        <div class="chapter-image">
            <img src="<?php echo $content_image; ?>" alt="Chapter Image">
        </div>
        <div class="chapter-content">
            <div class="content-text">
                <p><?php echo $content_text; ?></p>
            </div>
            <div class="content-video">
                <video src="<?php echo $content_video; ?>" controls></video>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>