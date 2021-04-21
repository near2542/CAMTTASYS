<?php
$redirect = 'location: ../course.php';

require_once ('../../redirect.php');
require_once ('../../db/connect.php');

session_start();
$conn->init();



if(isset($_POST['add']))
{
$id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$major_id = $_POST['major_id'];
}
else {
    redirect('../course.php');
    exit(0);
}

if($_SESSION['role']!=1)
{
    redirect('../../index.php') ;
    exit(0);
}

$query = sprintf("SELECT * FROM course WHERE course_id = %d and course_name = %s and major_id = %d "
                ,$conn->real_escape_string($id)
                ,$conn->real_escape_string($course_name)
                ,$conn->real_escape_string($major_id)
                );


$existCourses = $conn->query($query);
if($existCourses->num_rows > 0) { 
    $conn->close();
    $_SESSION['error'] = "Course Already Exits!";
    redirect('../course.php');
}

$insert = sprintf("INSERT INTO course (id,course_id,course_name,major_id) values ('','%d','%s','%d')",
    $conn->real_escape_string($id),
    $conn->real_escape_string($course_name),
    $conn->real_escape_string($major_id),
);

$status = $conn->query($insert);



if($status) {
    $_SESSION['error'] = "Add Course Success";
}
else $_SESSION['error'] = "Add Course Failed";

$conn->close();
 redirect('../course.php');



?>