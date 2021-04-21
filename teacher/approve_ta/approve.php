<?php
session_start();




require_once '../../db/connect.php';
if($_SESSION['role'] != 2) header('location:../../index.php');

if($_GET['id'])
{
    $registerid = $_GET['id'];
}
else
{
    $_SESSION['error'] = 'SOMETHING WENT WRONG PLEASE CONTACT ADMIN';
    header('location:../approve_ta.php');
    exit(0);
}

$checkLimitQuery = "SELECT * from register r
INNER JOIN matching_course m ON m.m_course_id = r.m_course_id
INNER JOIN user_tbl u ON u.user_id = r.user_id 
-- INNER JOIN ta_request t ON t.m_course_id = m.m_course_id
WHERE m.m_course_id = (SELECT m_course_id from register WHERE register_id = '$registerid' ) and r_status = 2 ";

$result = $conn->query($checkLimitQuery);
$total = 0;
if(!$result || mysqli_error($conn))
{
    die('SOEM THING WENT WRONG'+ mysqli_error($conn));
}

else{
    $limit = $conn->query("SELECT stu_num+ex_num AS num from ta_request t WHERE t.m_course_id = (SELECT m_course_id from register WHERE register_id = '$registerid')");
    $row = mysqli_fetch_row($limit);
    $total = $row[0];
}



$approveQuery = sprintf("UPDATE register SET r_status = 2
                WHERE register_id ='%d'",mysqli_escape_string($conn,$registerid));


$result =mysqli_query($conn,$approveQuery);

if(!$result || mysqli_error($conn))
{
    $_SESSION['error'] = 'SOMETHING WENT WRONG';
    // header('location:../approve.ta.php');
    exit(0);
}

$totalNowQuery = "SELECT count(*) from register r
INNER JOIN matching_course m ON m.m_course_id = r.m_course_id
INNER JOIN user_tbl u ON u.user_id = r.user_id 
INNER JOIN ta_request t ON t.m_course_id = m.m_course_id
WHERE m.m_course_id = (SELECT m_course_id from register WHERE register_id = '$registerid') and r_status = 2  AND user_type = 3";

$result = $conn->query($totalNowQuery);

if(!$result || mysqli_error($conn))
{
    die('SOEM THING WENT WRONG'+ mysqli_error($conn));
}

$totalNow = mysqli_fetch_row($result);

if($totalNow[0]+1 > $total)
{   $updateQuery = sprintf("UPDATE matching_course SET m_status = 0 
                    WHERE m_course_id = (SELECT m_course_id from register WHERE register_id = '%d') ",$registerid);
    $update = $conn->query($updateQuery);
    if(!$update || mysqli_error($conn))
    {   
        echo mysqli_error($conn);
        die('SOME THING WENT WRONG' );
    }
    $_SESSION['error'] ='add success | Number is fulfilled';
    header('location:../approve_ta.php');
    exit(0);
  
}



$_SESSION['error'] = 'add success';
header('location:../approve_ta.php');
exit(0);
?>