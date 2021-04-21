<?php
session_start();
require_once('../../db/connect.php');

$id = $_GET['id'];

$query = sprintf("UPDATE ta_request SET approved=1 where m_course_id = %d"
,mysqli_escape_string($conn,$id));

$result = mysqli_query($conn,$query);

if(!$result)
{
    die("something went wrong with {mysqli_error($connect)}");
}



$conn->close();

$_SESSION['error'] = 'Approved!';

header('location: ../approve_request_TA.php');
exit(0);


