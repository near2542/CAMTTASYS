<?php
session_start();
require_once "../../db/connect.php";

if(isset($_GET['id']) )
{
    $register_id = $_GET['id'];
}
else{
    $_SESSION['error'] = "Error occured, Please contact admin";
    header('location:../job.php');
    exit(0);
}


$signQuery = sprintf("UPDATE register SET r_status = 0
                    WHERE register_id = '%d'"
                ,mysqli_escape_string($conn,$register_id)
);

$result = mysqli_query($conn,$signQuery);

if(!$result || mysqli_error($conn))
{   
    $_SESSION['error']='SOMETHING WENT WRONG';
    die('SOMETHING WENT WRONG' + mysqli_error($conn));
}

$_SESSION['error'] = 'Course unsigned!';
header('location:../job.php');
exit(0);

