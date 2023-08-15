<?php

require 'config.php';
require 'awsCode/S3operation.php';

if (isset($_POST['update-quiz'])) {
  $id     = $_POST['update_id'];
  $title  = $_POST['quiz_title'];
  $category     = $_POST['quiz_category'];
  $timer  = $_POST['quiz_timer'];
  $point  = $_POST['quiz_point'];
  $description  = $_POST['quiz_description'];


  $udpate_image = '';

  if (isset($_FILES['image'])) {
    $fileType = 'image'; // Change this to 'video' for uploading videos
    $uploadedFile = $_FILES['image'];

    $uploadResult = uploadToS3($fileType, $uploadedFile);


    if ($uploadResult) {
      echo 'File uploaded successfully to S3!';
      // Save the uploaded file name to the $udpate_image variable
      $udpate_image = ", quiz_cover = '" . basename($uploadedFile['name']) . "'";
    } else {
      echo 'File upload failed.';
    }
  }


  $query = "UPDATE quiz SET quiz_title='$title', quiz_category='$category', quiz_timer='$timer', quiz_point= '$point', quiz_description = '$description' $udpate_image  WHERE quiz_id='$id'";
  $execute = mysqli_query($conn, $query);

  if ($execute) {
    echo '<script> alert("Quiz updated successfully!"); 
		window.location="teacher-quiz.php";
		</script>';
  } else {
    echo '<script> alert("An error has occured!"); </script>';
  }
}
