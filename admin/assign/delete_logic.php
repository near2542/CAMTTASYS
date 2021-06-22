<?php

session_start();

require_once('../../db/connect.php');

$conn->init();


if( $_SESSION['role']!=1)
{
    $_SESSION['error'] = 'failed';
    header('location: ../../index.php');
    exit(0);
}

if(isset($_POST['delete']))
{

    $id = $_GET['old'];
}
else{
    $_SESSION['error'] = 'failed';
    header('location: ../assign_courses.php');
    exit(0);
}

$query = sprintf("UPDATE matching_course SET deleted=1 WHERE m_course_id = %d",mysqli_escape_string($conn,$id));


$result = mysqli_query($conn,$query);


if(!$result) 
{
    $conn->close();
    die(mysqli_error($conn));
}
else{
    $_SESSION['error'] = "Delete Success";
    header('location: ../assign_courses.php');
    $conn->close();
    exit(0);
}

$_SESSION['error'] = "Something Went Wrong!";
 header($redirect);
 exit(0);

$conn->close();



