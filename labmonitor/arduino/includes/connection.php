<?php

$username = "root";
$pass = "";
$host = "localhost";
$db_name = "ethernet";
$con = mysqli_connect ($host, $username, $pass,$db_name);

// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>