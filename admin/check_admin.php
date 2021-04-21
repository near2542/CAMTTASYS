<?php 
session_start();

if(!isset($_SESSION['role']) )
{
    header('location: ../login.php');
}



if(isset($_SESSION['role']) && $_SESSION['role'] != 1)
{
    header('location: ../index.php');
}