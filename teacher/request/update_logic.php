<?php
require_once ('../../db/connect.php');

$redirect = 'location: ../request_courses.php';

session_start();
$conn->init();
if($_SESSION['role']!=2)
{
    header($redirect); 
    exit(0);
}



if(isset($_POST['update']))
{
$old = $_GET['old'];
$id = $_POST['course_id'];
$sem_id = $_POST['sem_id'];
$date = $_POST['day_id'];
$section = $_POST['section'];
$language = $_POST['language'];
$hour = $_POST['HOUR'];
$work_time = $_POST['WORK_TIME'];
// $course_name = $_POST['course_name'];
// $major_id = $_POST['major_id'];
}
else {
    header($redirect);
    exit(0);
}


$insert = sprintf("Update matching_course SET course_id='%d',
                 sem_id = '%d',
                t_date ='%d',
                t_time = '%s',
                section = '%d',
                    hr_per_week = '%d',
                    language = '%s'
        where m_course_id = '%d' ",
    $conn->real_escape_string($id),
    $conn->real_escape_string($sem_id),
    $conn->real_escape_string($date),
    $conn->real_escape_string($work_time),
    $conn->real_escape_string($section),
    $conn->real_escape_string($hour),
    $conn->real_escape_string($language),
    // $conn->real_escape_string($course_name),
    // $conn->real_escape_string($major_id),
    $conn->real_escape_string($old),
);

$status = $conn->query($insert);

if($status) {
    $_SESSION['error'] = "Update Course Success";
    header($redirect); exit(0);
}
die(mysqli_error($conn));

$_SESSION['error'] = "Update Course Failed";
 header($redirect);
 exit(0);



?>