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
$id = $_GET['id'];
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

$query = sprintf("UPDATE  matching_course SET  sem_id = '%d', course_id = '%d', section = '%s', t_date = '%s',
                    t_time = '%s', user_id = '%d', language = '%s', hr_per_week =  '%s', m_status = '1',deleted = '0' where m_course_id = '%d' ",
        $conn->real_escape_string($sem_id),
        $conn->real_escape_string($course_id),
        $conn->real_escape_string($section),
        $conn->real_escape_string($day),
        $conn->real_escape_string($work_time),
        $conn->real_escape_string($user_id),
        $conn->real_escape_string($language),
        $conn->real_escape_string($hour),
        $conn->real_escape_string($id)
            );


$result = $conn->query($query);

if(mysqli_error($conn)){
    echo mysqli_error($conn);
}
var_dump($result);
if(!$result)
{
    $conn->close();
    $_SESSION['error'] = "Something Went Wrong!";
    die('error' + mysqli_error($conn));
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