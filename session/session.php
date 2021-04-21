<?php session_start();
if(!isset($_SESSION['role']))
{
  session_destroy();
  header('location: login.php');
}
    ?>