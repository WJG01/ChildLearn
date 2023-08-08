<?php

require 'config.php';
require 'awsCode/S3operation.php';

if(isset($_POST['update-course']))
{
    $id             = $_POST['update_id'];
    $title          = $_POST['course_title'];
    $category       = $_POST['course_category'];
    $description    = $_POST['course_description'];


    if (isset($_FILES['image'])) {
      $fileType = 'image'; // Change this to 'video' for uploading videos
      $uploadedFile = $_FILES['image'];
  
      $uploadResult = uploadToS3($fileType, $uploadedFile);
  
  
      if ($uploadResult) {
        echo 'File uploaded successfully to S3!';
        // Save the uploaded file name to the $image variable
        $image = basename($uploadedFile['name']);
      } else {
        echo 'File upload failed.';
      }
    }

    $query = "UPDATE course SET course_title='$title', course_category='$category', course_description = '$description', course_cover = '$image'  WHERE course_id='$id'";
    $execute = mysqli_query($conn, $query);

    if ($execute)
    {
		echo '<script> alert("Course updated successfully!"); 
		window.location="teacher-course.php";
		</script>';
	}
	else
	{
		echo '<script> alert("An error has occured!"); </script>';
	}
}
