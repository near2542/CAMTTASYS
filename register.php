<?php

require_once "./db/connect.php";
// set variable
$username = $_POST['username'];
$password = $_POST['password'];
$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$student_id = $_POST['student_id'];
$major = $_POST['major'];
$user_type = $_POST['user_type'];
$cmu_email = $_POST['cmu_email'];
$line = $_POST['line'];
$tel = $_POST['tel'];
$facebook = $_POST['facebook'];
$portfolio = $_POST['portfolio'];

if(isset($_POST['submit']))
{
    $conn->init();
    $query = sprintf("INSERT INTO user_tbl VALUES (null,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',CURRENT_TIMESTAMP)",
    $conn->real_escape_string($_POST['username']),
    $conn->real_escape_string($_POST['password']),
    $conn->real_escape_string($_POST['Fname']),
    $conn->real_escape_string($_POST['Lname']),
    $conn->real_escape_string($_POST['student_id']),
    $conn->real_escape_string($_POST['major']),
    $conn->real_escape_string($_POST['cmu_email']),
    $conn->real_escape_string($_POST['line']),
    $conn->real_escape_string($_POST['facebook']),
    $conn->real_escape_string($_POST['tel']),
    $conn->real_escape_string($_POST['portfolio']),
    $conn->real_escape_string($_POST['user_type'])
        );
    $conn->query($query);
    $conn->close();
    header('location: login.php?register=pass');
}

else header('location: login.php?register=no');
