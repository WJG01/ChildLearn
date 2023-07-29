<?php 
require 'conn.php';

$id             = $_POST["id"];
$chapter_title  = $_POST['chapter_title'];
$content_text   = $_POST['content_text'];

$sql = "UPDATE course_chapter SET chapter_title = '$chapter_title', content_text = '$content_text' WHERE chapter_id = '$id'";
$execute = mysqli_query($conn, $sql);
if($execute) 
{
echo true;
}
else {
echo "Undefined error!";
}
?>