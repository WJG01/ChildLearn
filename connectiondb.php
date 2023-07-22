<!--Exercise 1: learn how to use the php to connect the MYSQL database-->
<?php
//create the user access information
/*$serverURL = "localhost";
$username = "root";
$password ="";*/
$serverURL = "childlearn-database.c1cevqakx6ry.us-east-1.rds.amazonaws.com";
$username = "admin";
$password ="Admin123#";
$database ="childlearn";

$connection = mysqli_connect($serverURL, $username, $password, $database);

if(!$connection)
{
    die("Error: Unable to connection. Error as here: ". mysqli_connect_error());
}

echo "Connect Successfully!";
//mysqli_close($connection);
?>