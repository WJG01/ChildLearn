<?php
session_start();
include("config.php");

if (isset($_SESSION['id'])) {
    $nav = "student-navi.php";
} else {
    echo '<script>alert("You must log in to your account first.")</script>';
    echo '<script>location.href="index.php"</script>';
}
include($nav);

$course_category = $_GET['cat'];
//Pagination
//Define how many results you want per page
$result_per_page = 10;

//Find out the number of results stored in the table
// $sql = "SELECT *, (SELECT COUNT(quques_id) FROM quiz_question qq WHERE (qq.quiz_id = q.quiz_id)) AS totalquestion 
// , (SELECT COUNT(stud_id) FROM history h WHERE (h.quques_id = qq.quques_id)) AS totalplays FROM quiz q INNER JOIN 
// quiz_question qq WHERE (qq.quiz_id = q.quiz_id) AND (q.quiz_category = '$quiz_category') GROUP BY q.quiz_id ORDER BY RAND()";
$sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count FROM course
INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
WHERE course.course_category = '$course_category'
GROUP BY course.course_id";

$result = mysqli_query($conn, $sql);
$number_of_results = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$course_title = $row['course_category'];

//Determine number of total pages available
$number_of_pages = ceil($number_of_results / $result_per_page);

//Determine which page number visitor is currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//Determine the SQL LIMIT staring number for the results on the displaying page
$starting_num = ($page - 1) * $result_per_page;

if (isset($_POST['search'])) {
    $search_query = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count 
                     FROM course
                     INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
                     WHERE course.course_category = '$course_category' AND course.course_title LIKE '%" . $_POST['search'] . "%'
                     GROUP BY course.course_id";

    $result = executeQuery($search_query);
    $starting_num = 0;
} else {
    //Retreive selected result from the table and display them on page
    $sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count 
            FROM course
            INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
            WHERE course.course_category = '$course_category'
            GROUP BY course.course_id ORDER BY RAND() 
            LIMIT " . $starting_num . ',' . $result_per_page;

    $result = mysqli_query($conn, $sql);
}


function executeQuery($query)
{
    require("config.php");
    $result = mysqli_query($conn, $query);
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8e94eefdff.js" crossorigin="anonymous"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
    <link rel="stylesheet" href="stylesheets/quiz-cards.css">
    <link rel="stylesheet" href="stylesheets/show-allquiz.css">
    <link rel="stylesheet" href="stylesheets/paginations.css">
    <title><?php echo $row['course_category'] ?> Course Page</title>
</head>

<body>
    <section class="show-all-quiz" id="show-all-quiz">
        <?php include("backBtn.php"); ?>
        <!-- <div class="title-and-search">
            <p class="show-quiz"><?php echo $row['course_category'] ?> Course</p>
            <div class="search-bar">
                <form method="POST" action="show-course.php?cat=<?php echo $course_category; ?>" autocomplete="off">
                    <input id="search-input" name="search" type="text" placeholder="Search course here...">
                    <input id="real-submit" type="submit" hidden>
                    <button id="search-btn" type="submit" name="submit" value="Search"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div> -->
        <div class="title-and-search">
            <p class="show-quiz"><?php echo $row['course_category'] ?> Course</p>
            <div class="search-bar">
                <form method="POST" action="show-course.php?cat=<?php echo $course_category; ?>" autocomplete="off">
                    <input id="search-input" name="search" type="text" placeholder="Search course here..." value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
                    <input id="real-submit" type="submit" hidden>
                    <button id="search-btn" type="submit" name="submit" value="Search"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!--A List of Quiz After User Enter a Relevant Letters -->
        <div class="quiz-list-group" id="show-list">

        </div>

        <div class="quiz-card-list-all" id="quiz-card-list-all">
            <div class="quiz-box">
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <a class="quiz-link" href="student-course-details.php?course_id=<?php echo $row['course_id']; ?>">
                        <div class="quiz-card">
                            <img class="quiz-cover-pic" src="Images/<?php echo $row['course_cover'] ?>" alt="Course cover picture">
                            <p class="quiz-title"><?php echo $row['course_title'] ?></p>
                            <div class="quiz-tag">
                                <p class="quiz-subject"><?php echo $row['course_category'] ?></p>
                                <p class="quiz-question"><?php echo $row['chapter_count'] ?> Chaps</p>
                            </div>
                        </div>
                    </a>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#search-input").keyup(function() {
                                var searchText = $(this).val();
                                if (searchText != '') {
                                    $.ajax({
                                        url: 'action-course.php?cat=<?php echo $row['course_category'] ?>',
                                        method: 'post',
                                        data: {
                                            query: searchText
                                        },
                                        success: function(response) {
                                            $("#show-list").html(response);
                                        }
                                    });
                                } else {
                                    $("#show-list").html('');
                                }
                            });
                            $(document).on('click', 'a', function() {
                                $("#search-input").val($(this).text());
                                $("#show-list").html('');

                            });
                        });
                    </script>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="page-links-div">
            <span class="page-links">Page</span>
            <?php
            //Display the links to the pages
            for ($page = 1; $page <= $number_of_pages; $page++) {
            ?>
                <a class="page-links" href="show-course.php?cat=<?php echo $course_category; ?>&page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <?php
            }; ?>
        </div>

    </section>
    <?php include("visitor-footer.php") ?>
</body>

</html>