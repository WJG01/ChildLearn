<?php 
include 'config.php';

extract($_GET);
$delete = $conn->query("DELETE FROM course_chapter where chapter_id=".$id);

if($delete)
	echo true;
?>