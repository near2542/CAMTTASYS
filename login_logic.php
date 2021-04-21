<?php
    include_once('./db/connect.php');
    if(isset($_POST['submit']))
    {
        $conn->init();
        $query = sprintf("SELECT user_id,username,user_type AS role,f_name,l_name FROM user_tbl where username = '%s' and password = '%s'",
        $conn->real_escape_string($_POST['username']),
        $conn->real_escape_string($_POST['password'])
            );
    $row = $conn->query($query);
    $result = $row->fetch_assoc();  
    $conn->close();
         if(!is_null($result)) 
        {
        session_start();
        $_SESSION['user'] = $result['username'];
        $_SESSION['role'] = $result['role'];
        $_SESSION['id'] = $result['user_id'];
        $_SESSION['name'] = "{$result['f_name']} {$result['l_name']}";
        header('location: index.php');
         } 
        else header('location: login.php?error=no');
    }

    else header('location: login.php?error=no');

    
    
?>