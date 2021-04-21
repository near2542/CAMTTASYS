<?php

session_start();

if(!isset($_SESSION['role']))
{
    session_destroy();
    header('location: ../login.php');
}

if(isset($_SESSION['role']) && $_SESSION['role']!= 2)
{
    header('location: ../index.php');
}


