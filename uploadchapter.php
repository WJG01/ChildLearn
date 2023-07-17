<?php 

require 'config.php';

if(isset($_POST['insert-chapter']))
{
	$title  		= $_POST['chapter_title'];
	$content  		= $_POST['content_text'];
    $order  		= $_POST['chapter_order'];
    $courseid  		= $_POST['course_id'];

    if (isset($_FILES['image'])) {
        $target_dir = "Images/";
        $target_file = $target_dir.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image = $_FILES['image']['name'];
    }

    if (isset($_FILES['video'])) {
        $target_dir = "Images/";
        $target_file = $target_dir.basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $target_file);
        $video = $_FILES['video']['name'];
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