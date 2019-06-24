<?php

//Getting RFID and Name from ardunio

$uid=$_GET['rfid']; 
$name=hex2str($_GET['name']); 
//$name=$_GET['name'];

echo "<b>Getting Data From Arduino </b><br><br>";
echo "<b>RFID : </b>".$uid."<br><b> Name : </b>".$name."<br>";


//processing those values to checkuser.php page
$extra="checkuser.php?rfid=".$uid."&name=".$name;
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');

header("location:http://$host$uri/$extra");

//$extra="labmonitor/arduino/checkuser.php?rfid=".$uid."&name=".$name;
//header( 'Location: $extra');

//method that converts hex values into ascii or alphabetic values
function hex2str($hex) 
{
    $str = '';
    for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
    return $str;
    //echo "My Name is ".$str;
}

?>