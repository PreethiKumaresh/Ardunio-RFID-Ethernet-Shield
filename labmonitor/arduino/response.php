<?php

$status = $_GET['status'];
$output = $_GET['output'];
$system_info = $_GET['system_info'];

//$result = $_GET['result'];
//$system_info = $_GET['system_info'];
//$result="hai";
//$system_info="pglab";
 
//echo "{\"result\": \"got it\", \"system_info\": \"this is a string from JSON\"}";
//echo "{\"result\": \"$result\", \"system_info\": \"$system_info\"}";

//session_start();

//$result = $_SESSION['result'];
//$system_info = $_SESSION['system_info'];

echo "{\"status\": \"$status\",\"result\": \"$output\", \"system_info\": \"$system_info\"}";
 
?>