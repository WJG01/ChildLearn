<?php

$course_search_cat = $_GET['cat'];
if (isset($_POST['query'])) {
    $inputText = $_POST['query'];
    // echo "Search Input: " . $inputText . "<br>"; // Display the input text
    $search_query = "SELECT * FROM course WHERE (course_category = '$course_search_cat') AND course_title LIKE '%$inputText%'";
    $result = executeQuery($search_query);
} else {
    $default_query = "SELECT * FROM course WHERE (course_category = '$course_search_cat')";
    $result = executeQuery($default_query);
}

function executeQuery($query)
{
    $connect = mysqli_connect("awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com", "admin", "Admin123#", "childlearn");
    $result = mysqli_query($connect, $query);
    return $result;
}
?>

<?php while ($row = mysqli_fetch_array($result)) : ?>
    <?php
    /* User Will Be Directly Transferred To The Specific Course Detail Page After Clicked */
    echo "
        <form method='POST' action='show-course.php' class='listed-item'>
        <a name='submit' class='list-group-item'>" . $row['course_title'] . "</a>
        </form>               
        ";
    ?>
<?php endwhile; ?>
