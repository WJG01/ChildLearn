<?php

require 'config.php';

if(isset($_POST['update-course']))
{
    $id             = $_POST['update_id'];
    $title          = $_POST['course_title'];
    $category       = $_POST['course_category'];
    $description    = $_POST['course_description'];

    $query = "UPDATE course SET course_title='$title', course_category='$category', course_description = '$description'  WHERE course_id='$id'";
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
?>