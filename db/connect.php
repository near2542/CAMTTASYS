<?php
$mode = "develop";
if($mode !== "production")
{
	$host = '127.0.0.1';
	$username = 'root';
	$password = '';
	$port = 3306;
	$dbname = 'tasys3';
}
else {
	$host = 'mysql-for-hosting';
	$username = 'tasystemdb';
	$password = 'O6jya0MONo41';
	$port = null;
	$dbname = 'tasystemdb';
}

// echo $host;
// echo $username;
// echo $password;
// echo $port;
// echo $dbname;
	$conn= new mysqli($host,$username,$password,$dbname,$port) or die("Could not connect to mysql".mysqli_error($conn));
	
?>
