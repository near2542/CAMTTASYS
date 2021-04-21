<?php
session_start();
if(!isset($_SESSION['role']) )
{
    session_destroy();
    header('location: ../login.php');
}
else{
    $ta = [3,4];
if(!in_array($_SESSION['role'],$ta)) header('location: ../index.php');
}





?>