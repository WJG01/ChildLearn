<?php

if (!isset($_SESSION)) {
    session_start();
}



require 'db.php';
require_once 'authEmail.php';
require 'vendor/autoload.php'; // Include the AWS SDK for PHP
include("awsCode/XrayOperation.php");


use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\SqlSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
use Pkerrigan\Xray\RemoteSegment;


$errors = array();

// Prevent student signup form refresh
$stud_first_name = "";
$stud_last_name = "";
$stud_username = "";
$stud_email = "";
$stud_password = "";
$stud_confirm_password = "";

// Prevent teacher form refresh
$teac_first_name = "";
$teac_last_name = "";
$teac_username = "";
$teac_email = "";
$teac_password = "";
$teac_confirm_password = "";
$image = "";

// When student clicks on the sign up button
if (isset($_POST['stud-reg'])) {
    $stud_first_name = $_POST['stud_first_name'];
    $stud_last_name = $_POST['stud_last_name'];
    $stud_username = $_POST['stud_username'];
    $stud_email = $_POST['stud_email'];
    $stud_password = $_POST['stud_password'];
    $stud_confirm_password = $_POST['stud_confirm_password'];

    $emailQuery = "SELECT * FROM student WHERE stud_email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $stud_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    // collect_db_xray_traces($carry_forward_query);

    if ($userCount > 0) {
        echo '<script>alert("Email already exists, please try a different email!")</script>';
        return false;
    }

    $usernameQuery = "SELECT * FROM student WHERE stud_username=? LIMIT 1";
    $stmt = $conn->prepare($usernameQuery);
    $stmt->bind_param('s', $stud_username);
    $stmt->execute();
    $result = $stmt->get_result();


    $userCount = $result->num_rows;
    $stmt->close();

    if ($userCount > 0) {
        echo '<script>alert("Username already exists, please try a different username!")</script>';
        return false;
    }

    if (count($errors) === 0) {
        $stud_password = password_hash($stud_password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = "1";

        $sql = "INSERT INTO student (stud_first_name, stud_last_name, stud_username, stud_email, hashed_password, verified, token) VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssis', $stud_first_name, $stud_last_name, $stud_username, $stud_email, $stud_password, $verified, $token);

        if ($stmt->execute()) {
            // login user
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['stud_username'] = $stud_username;
            $_SESSION['stud_email'] = $stud_email;
            $_SESSION['verified'] = $verified;

            subscribeEmail($stud_email, $token);

            // flash message
            echo "<script type='text/javascript'>alert('Account registered successfully, please verify your AWS Subscription through your email!');
            window.location='student-course-quiz.php';
            </script>";
            exit();
        } else {
            $errors['db_error'] = "Database error: failed to register";
        }
    }
}

// When teacher clicks on the sign up button
if (isset($_POST['teach-reg'])) {
    $teac_first_name = $_POST['teac_first_name'];
    $teac_last_name = $_POST['teac_last_name'];
    $teac_username = $_POST['teac_username'];
    $teac_email = $_POST['teac_email'];
    $teac_password = $_POST['teac_password'];
    $teac_confirm_password = $_POST['teac_confirm_password'];
    $teac_status = "Not Verified";

    if (isset($_FILES['image'])) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image = $_FILES['image']['name'];
    }

    $emailQuery = "SELECT * FROM teacher WHERE teac_email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $teac_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if ($userCount > 0) {
        echo '<script>alert("Email already exists, please try a different email!")
        </script>';
        return false;
    }

    $usernameQuery = "SELECT * FROM teacher WHERE teac_username=? LIMIT 1";
    $stmt = $conn->prepare($usernameQuery);
    $stmt->bind_param('s', $teac_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if ($userCount > 0) {
        echo '<script>alert("Username already exists, please try a different username!")</script>';
        return false;
    }

    if (count($errors) === 0) {
        $teac_password = password_hash($teac_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO teacher (teac_username, teac_password, teac_email, teac_first_name, teac_last_name, teac_edu_proof, teac_status) 
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $teac_username, $teac_password, $teac_email, $teac_first_name, $teac_last_name, $image, $teac_status);

        if ($stmt->execute()) {
            // login user
            $teach_id = $conn->insert_id;
            $_SESSION['teach_id'] = $teach_id;
            $_SESSION['teac_username'] = $teac_username;
            $_SESSION['teac_email'] = $teac_email;

            subscribeEmail($teac_email);

            echo "<script type='text/javascript'>alert('Your account request is now pending for approval from admin! In the meantime, please verify your AWS Subscription through your email');
            window.location='index.php';
            </script>";
            exit();
        } else {
            echo "<script type='text/javascript'>alert('Error!');
            window.location='index.php';
            </script>";
        }
    }
}

//X-Ray Tracking RDS
// When student / teacher clicks on the login button 
if (isset($_POST['stud_login'])) {



    $role = $_POST['roleSelector'];
    $log_username = $_POST['log_username'];
    $log_password = $_POST['log_password'];

    if ($role === 'student') {
        createFromExistingXrayTracing('RDS service');
        createNewSQLSegment('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com');

        // validation
        if (count($errors) === 0) {


            $sql = "SELECT * FROM student WHERE stud_email=? OR stud_username=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $log_username, $log_username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();



            set_SQLSegmentQuery($sql);

            submitXrayTracing();





            if ($user['verified'] == "0" && password_verify($log_password, $user['hashed_password'])) {
                // login success
                $_SESSION['id'] = $user['stud_id'];
                $_SESSION['stud_email'] = $user['stud_email'];
                $_SESSION['log_username'] = $user['stud_username'];
                $_SESSION['verified'] = $user['verified'];
                // flash message
                echo "<script type='text/javascript'>alert('Please verify your account through your email!');
                window.location='verification.php';
                </script>";


                exit();
            }

            if (password_verify($log_password, $user['hashed_password'])) {
                // login success
                $_SESSION['id'] = $user['stud_id'];
                $_SESSION['stud_email'] = $user['stud_email'];
                $_SESSION['log_username'] = $user['stud_username'];
                $_SESSION['verified'] = $user['verified'];
                // flash message
                echo "<script type='text/javascript'>alert('Successfully logged in!');
                window.location='student-course-quiz.php';
                </script>";

                exit();
            } else {
                echo "<script type='text/javascript'>alert('Invalid credentials!');
                window.location='index.php';
                </script>";
                return false;
            }
        }
    } else if ($role === 'teacher') { // When teacher clicks on the login button

        createFromExistingXrayTracing('RDS service');
        createNewSQLSegment('awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com');
        // validation
        if (count($errors) === 0) {


            $sql = "SELECT * FROM teacher WHERE teac_email=? OR teac_username=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $log_username, $log_username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            echo 'Success run result';

            // $sqlSegment->setQuery("SELECT * FROM student;");
            // $sqlSegment->end();

            // sleep(3);
            set_SQLSegmentQuery($sql);
            submitXrayTracing();



            if ($user['teac_status'] == "Verified" && password_verify($log_password, $user['teac_password'])) {
                // login success
                $_SESSION['teach_id'] = $user['teac_id'];
                $_SESSION['teac_email'] = $user['teac_email'];
                $_SESSION['log_username'] = $user['teac_username'];
                // flash message
                echo "<script type='text/javascript'>alert('Successfully logged in!');
                window.location='teacher-course.php';
                </script>";
                exit();
            } else if ($user['teac_status'] == "Not Verified" && password_verify($log_password, $user['teac_password'])) {
                // flash message
                echo "<script type='text/javascript'>alert('Your account is currently being reviewed by our admin! Accounts will normally be approved by our admin within 3 working days!');
                window.location='index.php';
                </script>";
            } else {
                echo "<script type='text/javascript'>alert('Invalid credentials!');
                window.location='index.php';
                </script>";
                //return false;
            }
        }
    }


    // Trace::getInstance()
    //     ->end()
    //     ->setResponseCode(http_response_code())
    //     ->submit(new DaemonSegmentSubmitter());

    // print_r(Trace::getInstance());
}

//logout user 
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['stud_username']);
    unset($_SESSION['stud_email']);
    unset($_SESSION['verified']);
    header('location: index.php');
    exit();
}

//logout teacher 
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['teach_id']);
    unset($_SESSION['teac_username']);
    unset($_SESSION['teac_email']);
    unset($_SESSION['verified']);
    header('location: index.php');
    exit();
}

// verify user by token
function verifyUser($token)
{
    global $conn;
    $sql = "SELECT * FROM student WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $update_query = "UPDATE student SET verified=1 WHERE token='$token'";

        if (mysqli_query($conn, $update_query)) {
            // log user in   
            $_SESSION['id'] = $user['stud_id'];
            $_SESSION['stud_username'] = $user['stud_username'];
            $_SESSION['stud_email'] = $user['stud_email'];
            $_SESSION['verified'] = 1;
            // flash message
            echo "<script type='text/javascript'>alert('Account has been successfully verified!');
            window.location='student-course-quiz.php';
            </script>";
            exit();
        }
    } else {
        echo 'User not found';
    }
}

// if user clicks on the forgot password button
if (isset($_POST['forgot-password'])) {


    if (isset($_POST['stud_email'])) {
        $passed_email = $_POST['stud_email'];
        $sql = "SELECT * FROM student WHERE stud_email='$passed_email' LIMIT 1";

    } else if (isset($_POST['teac_email'])) {
        $passed_email = $_POST['teac_email'];
        $sql = "SELECT * FROM teacher WHERE teac_email='$passed_email' LIMIT 1";

    } else if (isset($_POST['general_email'])) {
        $passed_email = $_POST['general_email'];

        // Try to find the email in the student table first
        $sql = "SELECT * FROM student WHERE stud_email='$passed_email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

       // echo 'RETURNING STUDENT RECORD', $user['stud_first_name'];

        // If not found in the teacher table, then try the student table
        if (!$user) {
            $sql = "SELECT * FROM teacher WHERE teac_email='$passed_email' LIMIT 1";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please select an email address!');
                </script>";
    }

    echo 'EMAIL PASSED ISS' . $passed_email;
    echo 'CURRENT TRACE ID IS ' . $_SESSION['trace_id'];

    if (!filter_var($passed_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script type='text/javascript'>alert('Email address is invalid!');
            window.location='forgot_password.php';
            </script>";
    }

    if (count($errors) == 0) {
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        $token = $user['token'];


        createFromExistingXrayTracing('Simple Notification Service');
        createNewRemoteSegment('sns: send email');


        //sending email here
        sendPasswordResetLink($passed_email, $token);

        end_Segment();
        submitXrayTracing();



        echo "<script type='text/javascript'>alert('An email has been successfully sent to your email address with a link to reset your password.');
            window.location='index.php';
            </script>";
        exit(0);
    }
}

// if user clicked on the reset password button
if (isset($_POST['reset-password-btn'])) {
    $stud_password = $_POST['stud_password'];
    $stud_confirm_password = $_POST['stud_confirm_password'];

    $stud_password = password_hash($stud_password, PASSWORD_DEFAULT);
    $stud_email = $_SESSION['stud_email'];

    if (count($errors) == 0) {
        $sql = "UPDATE student SET hashed_password='$stud_password' WHERE stud_email='$stud_email'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script type='text/javascript'>alert('Your password has been successfully resetted! Please re-login into your account using your new password.');
            window.location='index.php';
            </script>";
            exit(0);
        }
    }
}

function resetPassword($token)
{
    global $conn;
    $sql = "SELECT * FROM student WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['stud_email'] = $user['stud_email'];

    // Use JavaScript to redirect
    echo '<script>window.location = "reset-password.php";</script>';
    exit(0);
}