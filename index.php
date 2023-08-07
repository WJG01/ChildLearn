<?php
include("config.php");
require 'vendor/autoload.php'; // Include the AWS SDK for PHP


session_start();



use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;

Trace::getInstance()
    ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
    ->setName('ElasticBeanStalk')
    ->setUrl('http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com')
    ->setMethod($_SERVER['REQUEST_METHOD'])
    ->begin(100);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/index.css">
    <link rel="stylesheet" href="stylesheets/quiz-cards.css">
    <link rel="stylesheet" href="stylesheets/chatbot.css">
    <link rel="icon" type="image/png" href="Images/skillsoft-favicon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Landing Page</title>
</head>

<body>
    <?php include("visitor-navi.php"); ?>
    <div class="ads-container">
        <div class="left-title">
            <div class="content-des">
                <h1>Make Learning <br> Awesome!</h1>
                <p>
                    ChildLearn delivers engaging learning platfrom and provide a multiplication
                    turns the times tables into an awesome and captivating game experience.
                </p>
                <a class="learn-more" href="visitor-aboutus.php">Learn More</a>
            </div>
        </div>
        <div class="right-img">
            <img src="Images/visitor-ads-img.png">
        </div>
    </div>

    <div class="quiz-list-column" id="quiz-list-column">
        <h1>Courses</h1>
        <div class="quiz-box">
            <?php
            $sql = "SELECT course.course_id, course.course_cover, course.course_title, course.course_category, COUNT(*) AS chapter_count FROM course
            INNER JOIN course_chapter ON course.course_id = course_chapter.course_id
            GROUP BY course.course_id
            ORDER BY RAND()
            LIMIT 4";
            $result = mysqli_query($conn, $sql);
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
            ?>
        </div>
        <div class="view-more-btn">
            <a href="student-course-quiz.php">View More</a>
        </div>
    </div>

    <div class="quiz-list-column" id="quiz-list-column">
        <h1>Quizzes</h1>
        <div class="quiz-box">
            <?php
            $sql = "SELECT *, (SELECT COUNT(quques_id) FROM quiz_question qq WHERE (qq.quiz_id = q.quiz_id)) AS totalquestion 
                , (SELECT COUNT(stud_id) FROM history h WHERE (h.quques_id = qq.quques_id)) AS totalplays FROM quiz q INNER JOIN quiz_question qq 
                WHERE (qq.quiz_id = q.quiz_id) ORDER BY RAND() LIMIT 4";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <a class="quiz-link" href="student-quizquestion.php?quizid=<?php echo $row['quiz_id']; ?>">
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
            ?>
        </div>
        <div class="view-more-btn">
            <a href="student-course-quiz.php">View More</a>
        </div>
    </div>

    <div class="sign-up-teacher-column" id="sign-up-teacher-column">
        <div class="image-des">
            <img src="Images/visitor-index.png" alt="illustration-image">
        </div>
        <!--How does Learneasy work? (description)-->
        <div class="des-learneasy">
            <div class="des-content">
                <p>How does Skill<b>Soft.</b> works?</p>
                <h3>
                    It only takes minutes to create a learning game or trivia quiz on
                    any topic, in any language. Sign Up now as a teacher and start
                    creating your own quiz.
                </h3>
                <button class="sign-up-teacher-btn" onclick="location.href='teacher-signup.php'">Sign Up As a Teacher</button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="click">
    <label for="click" class="chatbot">
        <i class="fab fa-facebook-messenger"></i>
        <i class="fas fa-times"></i>
    </label>
    <div class="wrapper">
        <div class="title">Chat With Us Now</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something..." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    </div>
    <?php include("visitor-footer.php"); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#send-btn").on("click", function() {
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + $value + '</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');

                // start ajax code
                $.ajax({
                    url: 'chatbot.php',
                    type: 'POST',
                    data: 'text=' + $value,
                    success: function(result) {
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
</body>

</html>



<?php

Trace::getInstance()
    ->end()
    ->setResponseCode(http_response_code())
    ->submit(new DaemonSegmentSubmitter());

$_SESSION['trace_id'] = Trace::getInstance()->getTraceId();
$_SESSION['parent_id'] = Trace::getInstance()->getId();


// Print the Trace ID
// print_r(Trace::getInstance());

?>