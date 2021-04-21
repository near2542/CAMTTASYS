<?php
require_once ('../../db/connect.php');
require_once ('../../redirect.php');
$redirect = '../course.php';
session_start();
$conn->init();
if($_SESSION['role']!=1)
{
    redirect('../../index.php'); 
}



if(isset($_POST['update']))
{
$old = $_GET['old'];
$id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$major_id = $_POST['major_id'];
}
else {
    redirect($redirect);
    
}

$query = sprintf("SELECT * FROM course WHERE id = %d",$conn->real_escape_string($id));
$existCourses = $conn->query($query);
if($existCourses->num_rows < 0) { 
    $conn->close();
    $_SESSION['error'] = "Course Not Exist";
    redirect($redirect);
}

$insert = sprintf("Update course SET course_id='%d',course_name='%s',major_id='%d' where id = '%d' ",
    $conn->real_escape_string($id),
    $conn->real_escape_string($course_name),
    $conn->real_escape_string($major_id),
    $conn->real_escape_string($old),
);

$status = $conn->query($insert);

if($status) {
    $_SESSION['error'] = "Update Course Success";
    redirect($redirect);
}

else $_SESSION['error'] = "Update Course Failed";
$conn->close();
redirect($redirect);



?>