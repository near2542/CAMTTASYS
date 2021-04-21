<?php
session_start();

require_once '../../db/connect.php';

if($_SESSION['role'] == 3) header('location: ../../index.php');

if($_GET['id'] )
{
    $registerid = $_GET['id'];
}

else
{
    $_SESSION['error'] = 'SOMETHING WENT WRONG PLEASE CONTACT ADMIN';
    header('location:../approve_ta.php');
    exit(0);
}

$rejectQuery = sprintf("UPDATE register SET r_status = 3
WHERE register_id ='%d'",mysqli_escape_string($conn,$registerid));

$result = mysqli_query($conn,$rejectQuery);

if(!$result || mysqli_error($conn)) die('SOMETHING WENT WRONG');



$_SESSION['error'] = 'reject success success';
header('location:../approve_ta.php');
exit(0);