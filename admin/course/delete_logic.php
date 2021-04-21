<?php
require_once ('../../db/connect.php');
require_once ('../../redirect.php');
$redirect = 'location: ../course.php';

session_start();
$conn->init();
if($_SESSION['role']!=1)
{
    redirect('../../index.php');
    exit(0);
}

if(isset($_POST['delete']))
{
$old = $_GET['old'];
}
else {
    redirect('../course.php');
    exit(0);
}

$query = sprintf("SELECT * FROM course WHERE id = %d",$conn->real_escape_string($old));
$existCourses = $conn->query($query);
if($existCourses->num_rows < 0) { 
    $_SESSION['error'] = "Delete failed";
    redirect('../course.php');
}

$insert = sprintf("Update course SET deleted='1' where course_id = '%d' ",
    $conn->real_escape_string($old),
);

$status = $conn->query($insert);



if($status) {
    $_SESSION['error'] = "Delete Success";
    redirect('../course.php');
}

else $_SESSION['error'] = "Delete Failed";

redirect('../course.php');



?>