<?php

session_start();

require_once('../../db/connect.php');

$redirect = 'location: ../assign_courses.php';

$conn->init();

if( $_SESSION['role']!=1)
{
    $_SESSION['error'] = 'failed';
    header('location: ../../index.php');
    exit(0);
}

if(isset($_POST['add']))
{
$sem_id = $_POST['sem_id'];
$course_id = $_POST['course_id'];
$section = $_POST['section'];
$day = $_POST['day_id'];
$work_time = $_POST['WORK_TIME'];
$language = $_POST['language'];
$user_id = $_POST['teacher_id'];
$hour = $_POST['HOUR'];
}
else {
    $_SESSION['error'] = 'failed';
    header($redirect);
    exit(0);
}

$query = sprintf("INSERT INTO matching_course values ('','%d','%d','%s','%s','%s','%d','%s','%s','1','0')",
        $conn->real_escape_string($sem_id),
        $conn->real_escape_string($course_id),
        $conn->real_escape_string($section),
        $conn->real_escape_string($day),
        $conn->real_escape_string($work_time),
        $conn->real_escape_string($user_id),
        $conn->real_escape_string($language),
        $conn->real_escape_string($hour),
            );


$result = $conn->query($query);

if(mysqli_error($conn)){
    echo mysqli_error($conn);
}
if(!$result)
{
    $conn->close();
    $_SESSION['error'] = "Something Went Wrong!";
    die(mysqli_error($conn));
    header($redirect); exit(0);
}

else{
    $_SESSION['error'] = "Add Course Success";
    header($redirect);
    exit(0);
}

$_SESSION['error'] = "Something Went Wrong!";
 header($redirect);
 exit(0);

$conn->close();