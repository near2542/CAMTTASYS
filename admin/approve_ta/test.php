<?php
require_once '../../db/connect.php';

$limit = $conn->query("SELECT stu_num+ex_num AS num from ta_request t WHERE t.m_course_id = (SELECT m_course_id from register WHERE register_id = '9')");
    $row = mysqli_fetch_row($limit);
    $total = $row[0];
    echo $total;