<?php

if (!isset($_SESSION)) {
	session_start();
}

require 'vendor/autoload.php'; // Include the AWS SDK for PHP

require 'config.php';
require 'awsCode/S3operation.php';

use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\RemoteSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;



if (isset($_POST['insert-course'])) {
	$title  		= $_POST['course_title'];
	$category  		= $_POST['course_category'];
	$description 	= $_POST['course_description'];
	$date			= $_POST['course_create_date'];
	$tid			= $_POST['tid'];

	if (isset($_FILES['image'])) {
		$fileType = 'image'; // Change this to 'video' for uploading videos
		$uploadedFile = $_FILES['image'];

		// Start X-Ray Tracing for S3
		Trace::getInstance()
			->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
			->setParentId($_SESSION['parent_id'])
			->setTraceId($_SESSION['trace_id'])
			->setIndependent(true)
			->setName('S3 Bucket Service')
			->setUrl($_SERVER['REQUEST_URI'])
			->setMethod($_SERVER['REQUEST_METHOD'])
			->begin(100);

		Trace::getInstance()
			->getCurrentSegment()
			->addSubsegment(
				(new RemoteSegment())
					->setName('s3: upload image')
					->begin(100)
			);

		$uploadResult = uploadToS3($fileType, $uploadedFile);


		// End X-Ray Tracing: Successfully Uploaded Image
		Trace::getInstance()
			->getCurrentSegment()
			->end();

		Trace::getInstance()
			->end()
			->setResponseCode(http_response_code())
			->submit(new DaemonSegmentSubmitter());

			print_r(Trace::getInstance());

		if ($uploadResult) {
			echo 'File uploaded successfully to S3!';
			// Save the uploaded file name to the $image variable
			$image = 'courseCover_' . $title . '_' . basename($uploadedFile['name']);
		} else {
			echo 'File upload failed.';
		}
	}

	$query = "INSERT INTO course (`course_title`, `course_category`, `course_cover`, `course_description`, `course_create_date`, `teac_id`) 
              VALUES ('$title', '$category', '$image', '$description', '$date', '$tid')";
	$execute = mysqli_query($conn, $query);

	if ($execute) {
		echo '<script> alert("Course added successfully!"); 
		window.location="teacher-course.php";
		</script>';
	} else {
		echo '<script> alert("An error has occured!"); </script>';
	}
}
