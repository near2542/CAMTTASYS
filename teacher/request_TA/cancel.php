<?php

session_start();

require_once('../../db/connect.php');

$redirect = 'location: ../request_TA.php';

$conn->init();



if( $_SESSION['role']!=2)
{
    $_SESSION['error'] = 'failed';
    header('../../index.php');
    exit(0);
}

if(isset($_POST['add']))
{
$id = $_GET['id'];
$student = $_POST['Student'];
$external = $_POST['Ex'];
$note = $_POST['Request'];

if(!is_numeric((int)$student)) $student = 0;
if(!is_numeric((int)$external)) $student = 0;
}

else {
    $_SESSION['error'] = 'failed';
    header($redirect);
    exit(0);
}


$query = sprintf("INSERT INTO ta_request values ('','%d','%d','%d','%s',NULL,'%d','')",
        $conn->real_escape_string($id),
        $conn->real_escape_string($student),
        $conn->real_escape_string($external),
        $conn->real_escape_string($note),
        $conn->real_escape_string($_SESSION['id']),
            );


$result = $conn->query($query);

if(mysqli_error($conn)){
    die (mysqli_error($conn));
}



if(!$result)
{
    $conn->close();
    $_SESSION['error'] = "Something Went Wrong!1";
    header($redirect); exit(0);
}

else{
    $_SESSION['error'] = "Request has been made ";
    header($redirect);
    exit(0);
}

$_SESSION['error'] = "Something Went Wrong!2";
 header($redirect);
 exit(0);

$conn->close();