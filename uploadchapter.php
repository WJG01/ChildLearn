<?php 

if (!isset($_SESSION)) {
	session_start();
}

require 'vendor/autoload.php'; // Include the AWS SDK for PHP

require 'config.php';
require 'awsCode/S3operation.php';
require 'awsCode/XrayOperation.php';

use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\RemoteSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;

if(isset($_POST['insert-chapter']))
{
	$title  		= $_POST['chapter_title'];
	$content  		= $_POST['content_text'];
    $order  		= $_POST['chapter_order'];
    $courseid  		= $_POST['course_id'];

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

    if (isset($_FILES['video'])) {
        $fileType = 'video'; // Change this to 'video' for uploading videos
		$uploadedFile = $_FILES['video'];

        $uploadResult = uploadToS3($fileType, $uploadedFile);

        if ($uploadResult) {
			echo 'File uploaded successfully to S3!';
			// Save the uploaded file name to the $image variable
			$video = basename($uploadedFile['name']);
		} else {
			echo 'File upload failed.';
		}


    }

	$query = "INSERT INTO course_chapter (`chapter_title`, `chapter_order`, `content_text`, `content_image`, `content_video`, `course_id`) 
              VALUES ('$title', '$order', '$content', '$image', '$video', '$courseid')";
	$execute = mysqli_query($conn, $query);

	if($execute) 
	{
		echo '<script> alert("Chapter added successfully!"); 
		window.location.href="course-view.php?id='.$courseid.'";
		</script>';
	}
	else
	{
		echo '<script> alert("An error has occured!"); </script>';
	}
}

?>