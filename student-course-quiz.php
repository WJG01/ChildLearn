<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'vendor/autoload.php'; // Include the AWS SDK for PHP
use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\RemoteSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;

if (!(isset($_SESSION['id']) || $_SESSION['teach_id'])) {
    echo '<script>alert("You must log in to your account first.")</script>';
    echo '<script>location.href="index.php"</script>';
}
include("config.php");
include("awsCode/S3operation.php");

if (isset($_SESSION['id'])) {
    $log_userid = $_SESSION['id'];
    $sql = "SELECT * FROM student WHERE stud_id = '$log_userid' LIMIT 1";
} else if (isset($_SESSION['teach_id'])) {
    $log_userid = $_SESSION['teach_id'];
    $sql = "SELECT * FROM teacher WHERE teac_id = '$log_userid' LIMIT 1";
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/stud-course-quiz.css">
    <link rel="stylesheet" href="stylesheets/quiz-cards.css">
    <!-- <link rel="stylesheet" href="stylesheets/show-all-quiz.css"> -->
    <link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
    <script src="https://kit.fontawesome.com/8e94eefdff.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Quiz Homepage</title>
</head>

<body>
    <?php
    if (isset($_SESSION['teach_id'])) {
        include("teacher-navi.php");
    } else {
        include("student-navi.php");
    }
    ?>

    <div class="quiz-greetings" id="quiz-greetings">
        <span class="quiz-greetings-title">Welcome Back, <b>
                <?php
                if (isset($_SESSION['id'])) {
                    echo $row['stud_first_name']; ?>&nbsp;<?php echo $row['stud_last_name'];
                                                        } else if (isset($_SESSION['teach_id'])) {
                                                            echo $row['teac_first_name']; ?>&nbsp;<?php echo $row['teac_last_name'];
                                                                                                }

                                                                                                    ?>
            </b></span>
    </div>

    <div class="student-quiz-tab" id="student-quiz-tab">
        <div class="button-cat">
            <!-- <button class="tablinks" onclick="openCity(event, 'all-quiz')" id="defaultOpen">Quiz</button> -->
            <button class="tablinks" onclick="openCity(event, 'all-course')" id="defaultOpen">Courses</button>
            <button class="tablinks" onclick="openCity(event, 'all-quiz')">Quiz</button>
            <button class="tablinks" onclick="openCity(event, 'completed-quiz')">Completed</button>
        </div>
    </div>


    <!-- Course tab -->
    <div id="all-course" class="tabcontent">
        <div class="quiz-container">
            <div class="business-quiz-col">
                <div class="title-btn">
                    <p>Language and Literacy</p>
                    <button onclick="location.href='show-course.php?cat=Language and Literacy'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count FROM course
                    INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
                    WHERE course.course_category = 'Language and Literacy'
                    GROUP BY course.course_id
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);

                    // Start X-Ray Tracing for CloudFront- section-1
                    Trace::getInstance()
                        ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
                        ->setParentId($_SESSION['parent_id'])
                        ->setTraceId($_SESSION['trace_id'])
                        ->setIndependent(true)
                        ->setName('Cloudfront Service')
                        ->setUrl($_SERVER['REQUEST_URI'])
                        ->setMethod($_SERVER['REQUEST_METHOD'])
                        ->begin(100);

                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->addSubsegment(
                            (new RemoteSegment())
                                ->setName('cloudfront: load image')
                                ->begin(100)
                        );

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-course-chapter.php?course_id=<?php echo $row['course_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="<?php echo getImageFromCloudFront($row['course_cover']); ?>" alt="Course cover picture">
                                <p class="quiz-title"><?php echo $row['course_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject"><?php echo $row['course_category'] ?></p>
                                    <p class="quiz-question"><?php echo $row['chapter_count'] ?> Chaps</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }

                    //End X-Ray Tracing for CloudFront-section-1
                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->end();

                    // print_r(Trace::getInstance());
                    ?>
                </div>
            </div>
            <div class="design-quiz-col">
                <div class="title-btn">
                    <p>Mathematics and Logic</p>
                    <button onclick="location.href='show-course.php?cat=Mathematics and Logic'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count FROM course
                    INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
                    WHERE course.course_category = 'Mathematics and Logic'
                    GROUP BY course.course_id
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);

                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->begin();

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-course-chapter.php?course_id=<?php echo $row['course_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['course_cover'] ?>" alt="Course cover picture">
                                <p class="quiz-title"><?php echo $row['course_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject"><?php echo $row['course_category'] ?></p>
                                    <p class="quiz-question"><?php echo $row['chapter_count'] ?> Chaps</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->end();
                    ?>
                </div>
            </div>
            <div class="it-quiz-col">
                <div class="title-btn">
                    <p>Science and Discovery</p>
                    <button onclick="location.href='show-course.php?cat=Science and Discovery'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count FROM course
                    INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
                    WHERE course.course_category = 'Science and Discovery'
                    GROUP BY course.course_id
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);
                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->begin();

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-course-chapter.php?course_id=<?php echo $row['course_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['course_cover'] ?>" alt="Course cover picture">
                                <p class="quiz-title"><?php echo $row['course_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject"><?php echo $row['course_category'] ?></p>
                                    <p class="quiz-question"><?php echo $row['chapter_count'] ?> Chaps</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    Trace::getInstance()
                        ->getCurrentSegment()
                        ->end();

                    Trace::getInstance()
                        ->end()
                        ->setResponseCode(http_response_code())
                        ->submit(new DaemonSegmentSubmitter());

                    // print_r(Trace::getInstance());

                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Tab -->
    <div id="all-quiz" class="tabcontent">
        <div class="quiz-container">
            <div class="business-quiz-col">
                <div class="title-btn">
                    <p>Language and Literacy</p>
                    <button onclick="location.href='show-quiz.php?cat=Language and Literacy'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT quiz.*, course.course_title,
                    (SELECT COUNT(quques_id) FROM quiz_question qq WHERE qq.quiz_id = quiz.quiz_id) AS totalquestion,
                    (SELECT COUNT(stud_id) FROM history h WHERE h.quques_id = qq.quques_id) AS totalplays
                    FROM quiz
                    INNER JOIN course ON quiz.course_id = course.course_id
                    INNER JOIN quiz_question qq ON qq.quiz_id = quiz.quiz_id
                    WHERE quiz.quiz_category = 'Language and Literacy'
                    GROUP BY quiz.quiz_id
                    ORDER BY RAND()
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-quizquestion.php?quizid=<?php echo $row['quiz_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['quiz_cover'] ?>" alt="Quiz cover picture">
                                <p class="quiz-title"><?php echo $row['quiz_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $row['course_title'] ?></p>
                                    <p class="quiz-question"><?php echo $row['totalquestion'] ?>Qs</p>
                                    <p class="quiz-play"><?php echo $row['totalplays'] ?>plays</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="design-quiz-col">
                <div class="title-btn">
                    <p>Mathematics and Logic</p>
                    <button onclick="location.href='show-quiz.php?cat=Mathematics and Logic'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT quiz.*, course.course_title,
                    (SELECT COUNT(quques_id) FROM quiz_question qq WHERE qq.quiz_id = quiz.quiz_id) AS totalquestion,
                    (SELECT COUNT(stud_id) FROM history h WHERE h.quques_id = qq.quques_id) AS totalplays
                    FROM quiz
                    INNER JOIN course ON quiz.course_id = course.course_id
                    INNER JOIN quiz_question qq ON qq.quiz_id = quiz.quiz_id
                    WHERE quiz.quiz_category = 'Mathematics and Logic'
                    GROUP BY quiz.quiz_id
                    ORDER BY RAND()
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-quizquestion.php?quizid=<?php echo $row['quiz_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['quiz_cover'] ?>" alt="Quiz cover picture">
                                <p class="quiz-title"><?php echo $row['quiz_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $row['course_title'] ?></p>
                                    <p class="quiz-question"><?php echo $row['totalquestion'] ?>Qs</p>
                                    <p class="quiz-play"><?php echo $row['totalplays'] ?>plays</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="it-quiz-col">
                <div class="title-btn">
                    <p>Science and Discovery</p>
                    <button onclick="location.href='show-quiz.php?cat=Science and Discovery'">View More</button>
                </div>
                <div class="quiz-box">
                    <?php
                    include("config.php");
                    $sql = "SELECT quiz.*, course.course_title,
                    (SELECT COUNT(quques_id) FROM quiz_question qq WHERE qq.quiz_id = quiz.quiz_id) AS totalquestion,
                    (SELECT COUNT(stud_id) FROM history h WHERE h.quques_id = qq.quques_id) AS totalplays
                    FROM quiz
                    INNER JOIN course ON quiz.course_id = course.course_id
                    INNER JOIN quiz_question qq ON qq.quiz_id = quiz.quiz_id
                    WHERE quiz.quiz_category = 'Science and Discovery'
                    GROUP BY quiz.quiz_id
                    ORDER BY RAND()
                    LIMIT 4";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <a class="quiz-link" href="student-quizquestion.php?quizid=<?php echo $row['quiz_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['quiz_cover'] ?>" alt="Quiz cover picture">
                                <p class="quiz-title"><?php echo $row['quiz_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $row['course_title'] ?></p>
                                    <p class="quiz-question"><?php echo $row['totalquestion'] ?>Qs</p>
                                    <p class="quiz-play"><?php echo $row['totalplays'] ?>plays</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Tab -->
    <div id="completed-quiz" class="tabcontent">
        <div class="complete-quiz-container">
            <div class="quiz-box">
                <?php
                include("config.php");
                $sql = "SELECT *, (SELECT COUNT(quques_id) FROM quiz_question qq WHERE (qq.quiz_id = q.quiz_id)) AS totalquestion 
                    , (SELECT COUNT(stud_id) FROM history h WHERE (h.quques_id = qq.quques_id)) AS totalplays FROM quiz q INNER JOIN quiz_question qq, history h 
                    WHERE (qq.quiz_id = q.quiz_id) AND (qq.quques_id = h.quques_id) AND (h.stud_id = '$sid') GROUP BY q.quiz_id ORDER BY RAND()";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                        <a class="quiz-link completed" href="student-result.php?qid=<?php echo $row['quiz_id']; ?>" id="<?php echo $row['quiz_id']; ?>">
                            <div class="quiz-card">
                                <img class="quiz-cover-pic" src="Images/<?php echo $row['quiz_cover'] ?>" alt="Quiz cover picture">
                                <p class="quiz-title"><?php echo $row['quiz_title'] ?></p>
                                <div class="quiz-tag">
                                    <p class="quiz-subject"><?php echo $row['quiz_category'] ?></p>
                                    <p class="quiz-question"><?php echo $row['totalquestion'] ?>Qs</p>
                                    <p class="quiz-play"><?php echo $row['totalplays'] ?>plays</p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                } else {
                    ?>
                    <h2 style="font-family: 'Nunito'; font-style: normal; font-weight: 400; font-size: 24px; line-height: 33px; color: #50514F; margin-bottom: 200px" id="no-quiz-title">Oops seems like you didn't attempt any quiz yet!</h2>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Include jQuery - see http://jquery.com -->
    <script>
        $('.completed').on('click', function() {
            var t = (this.id);
            if (confirm("Do you want to reattempt the quiz?")) {
                $(".completed").attr("href", "student-quizquestion.php?quizid=" + t);
            } else {
                return true;
            }
        });
    </script>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

    <?php include("visitor-footer.php"); ?>
</body>

</html>