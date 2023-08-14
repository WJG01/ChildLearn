<?php
$dbHost = 'awseb-e-ecfp7dp5pn-stack-awsebrdsdatabase-3kt0ellbqgdt.c1cevqakx6ry.us-east-1.rds.amazonaws.com'; // RDS endpoint
$dbUsername = 'admin'; // RDS username
$dbPassword = 'Admin123#'; // RDS password
$dbName = 'childlearn'; // RDS database name

// Create a conn
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check conn
if (!$conn) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
    // echo "Connection successful!";
}
?>