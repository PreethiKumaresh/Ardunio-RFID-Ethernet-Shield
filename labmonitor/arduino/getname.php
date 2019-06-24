<?php
include ('connection.php');

//get name of the uid
$myname=" ";

$uid=$_GET['rfid']; //getting uid from ardunio

echo "UID: ".$uid."<br>";

$sql_select = "SELECT * FROM id_detail WHERE uid='$uid'";
if($result=mysqli_query($con,$sql_select))
{
	while($row = mysqli_fetch_array($result))
	{
		$myname = $row['name'];
	}

	echo "My Name is ".$myname."<br>";
}
else
{
echo "error is ".mysqli_error($con );
}
?>  