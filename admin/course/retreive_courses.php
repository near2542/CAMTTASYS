<?php
require_once ('../../db/connect.php');
require_once ('../../redirect.php');


$redirect = 'location: ../course.php';

session_start();
$conn->init();
if($_SESSION['role']!=1)
{
   redirect('../../index.php');
}

if(isset($_POST['delete']))
{
$old = $_GET['old'];
}


$query = sprintf("SELECT * FROM course WHERE id = '%d'",$conn->real_escape_string($old));
$existCourses = $conn->query($query);
if(!$existCourses || mysqli_error($conn))
{
    die(mysqli_error($conn));
}
if(!$existCourses->num_rows > 0) { 
    $conn->close();
    $_SESSION['error'] = "Retreieve failed";
    redirect('../course.php');
}

$insert = sprintf("Update course SET deleted='0' where id = '%d' ",
    mysqli_real_escape_string($conn,$old));

$status = $conn->query($insert);

if(!$status || mysqli_error($conn))
{
    die(mysqli_error($conn));
}

if($status) {
    $_SESSION['error'] = "Retrieve Success";
    $conn->close();
    redirect('../course.php');
}

else $_SESSION['error'] = "Retrieve Failed";
$conn->close();
 redirect('../course.php');



?>