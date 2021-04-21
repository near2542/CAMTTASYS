<?php
session_start();
require_once "../../db/connect.php";

if(isset($_GET['id']) && isset($_GET['m_course_id']))
{
    $user_id = $_GET['id'];
    $m_course_id = $_GET['m_course_id'];
    $register_id =$_GET['register_id'];
}
else{
    $_SESSION['error'] = "Error occured, Please contact admin";

    header('location:../job.php');
    exit(0);
}

$signquery = '';

if($register_id != '')
{
    $signQuery = $signQuery = sprintf("UPDATE register SET r_status = 1
    WHERE register_id = '%d'"
,mysqli_escape_string($conn,$register_id));
}

else{
$signQuery = sprintf("INSERT INTO register (user_id,m_course_id,r_status) values ('%d','%s',1)"
                ,mysqli_escape_string($conn,$user_id)
                ,mysqli_escape_string($conn,$m_course_id)
            );
}

$result = mysqli_query($conn,$signQuery);


if(!$result || mysqli_error($conn))
{   
    $_SESSION['error']='SOMETHING WENT WRONG';
    echo 'SOMETHING WENT WRONG' . mysqli_error($conn);
    die('SOMETHING WENT WRONG' + mysqli_error($conn));
    exit(0);
}

$_SESSION['error'] = 'Course Signed!';
header('location:../job.php');
exit(0);

