<?php 
include 'config.php';
extract($_GET);
$get = $conn->query("SELECT * FROM course_chapter where course_id= ".$id)->fetch_array();
$delete = $conn->query("DELETE FROM course where course_id= ".$id);
$delete1 = $conn->query("DELETE FROM course_chapter where course_id= ".$id);
if($delete)
{
    echo true;
}
else
{
    echo '<script> alert("An error has occured!"); </script>';
}
?>