<?php 
require 'config.php';
require 'awsCode/S3operation.php';

$id = $_POST["id"];
$chapter_title = $_POST['chapter_title'];
$content_text = $_POST['content_text'];

$update_image = '';
$update_video = '';

if (isset($_FILES['image'])) {
    $fileType = 'image'; 
    $uploadedFile = $_FILES['image'];

    $uploadResult = uploadToS3($fileType, $uploadedFile);

    if ($uploadResult) {
        echo 'File uploaded successfully to S3!';
        // Save the uploaded file name to the $update_image variable
        $update_image = ", content_image = '" . basename($uploadedFile['name']) . "'";
    } else {
        echo 'File upload failed.';
    }
}

if (isset($_FILES['video'])) {
    $fileType = 'video'; 
    $uploadedFile = $_FILES['video'];

    $uploadResult = uploadToS3($fileType, $uploadedFile);

    if ($uploadResult) {
        echo 'File uploaded successfully to S3!';
        // Save the uploaded file name to the $update_video variable
        $update_video = ", content_video = '" . basename($uploadedFile['name']) . "'";
    } else {
        echo 'File upload failed.';
    }
}

$sql = "UPDATE course_chapter SET chapter_title = '$chapter_title', content_text = '$content_text' $update_image $update_video WHERE chapter_id = '$id'";
$execute = mysqli_query($conn, $sql);

if ($execute) {
    echo true;
} else {
    echo "Undefined error!";
}
?>