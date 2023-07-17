<?php 

require 'config.php';

if(isset($_POST['insert-course']))
{
	$title  		= $_POST['course_title'];
	$category  		= $_POST['course_category'];
	$description 	= $_POST['course_description'];
	$date			= $_POST['course_create_date'];
	$tid			= $_POST['tid'];

	if (isset($_FILES['image'])) {
        $target_dir = "Images/";
        $target_file = $target_dir.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image = $_FILES['image']['name'];
    }

	$query = "INSERT INTO course (`course_title`, `course_category`, `course_cover`, `course_description`, `course_create_date`, `teac_id`) 
              VALUES ('$title', '$category', '$image', '$description', '$date', '$tid')";
	$execute = mysqli_query($conn, $query);

	if($execute) 
	{
		echo '<script> alert("Course added successfully!"); 
		window.location="teacher-course.php";
		</script>';
	}
	else
	{
		echo '<script> alert("An error has occured!"); </script>';
	}
}

?>