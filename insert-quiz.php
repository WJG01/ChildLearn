<?php 

require 'config.php';
require 'awsCode/S3operation.php';
require 'awsCode/Xrayoperation.php';

if(isset($_POST['insert-quiz']))
{
	$title  		= $_POST['quiz_title'];
	$category  		= $_POST['quiz_category'];
	$timer  		= $_POST['quiz_timer'];
	$points 		= $_POST['quiz_point'];
	$description 	= $_POST['quiz_description'];
	$date			= $_POST['quiz_create_date'];
	$tid			= $_POST['tid'];

	
	if (isset($_FILES['image'])) {
	  $fileType = 'image'; 
	  $uploadedFile = $_FILES['image'];
  
	  $uploadResult = uploadToS3($fileType, $uploadedFile);
  
  
	  if ($uploadResult) {
		echo 'File uploaded successfully to S3!';
		// Save the uploaded file name to the $udpate_image variable
		$image = basename($uploadedFile['name']);
	  } else {
		echo 'File upload failed.';
	  }
	}

	$query = "INSERT INTO quiz (`quiz_title`, `quiz_category`, `quiz_cover`, `quiz_timer`, `quiz_point`, `quiz_description`, `quiz_create_date`, `teac_id`) VALUES ('$title', '$category', '$image', '$timer', '$points', '$description', '$date', '$tid')";
	$execute = mysqli_query($conn, $query);

	if($execute) 
	{
		echo '<script> alert("Quiz added successfully!"); 
		window.location="teacher-quiz.php";
		</script>';
	}
	else
	{
		echo '<script> alert("An error has occured!"); </script>';
	}
}
