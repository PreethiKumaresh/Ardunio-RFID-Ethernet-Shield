<?php

include("includes/connection.php");

$msg=0;

$uid=$_GET['rfid']; 
$name=hex2str($_GET['name']); 

//$uid=$_GET['rfid']; 
//$name=$_GET['name']; 

//echo "<b>Getting Data From Arduino </b><br><br>";
//echo "<b>RFID : </b>".$uid."<br><b> Name : </b>".$name."<br>";

//echo "<b>Checking Status Of User Entry in lab </b><br>";
//echo "<b>RFID : </b>".$uid."<br><b> Name : </b>".$name."<br>";

$data=null; //check if it is a new user or old user

$sql_select = "SELECT sys_allocated, tag_seen FROM lab_checkin WHERE rfid='$uid'";
if($result=mysqli_query($con,$sql_select))
{
	while($row = mysqli_fetch_array($result))
	{
		if($row['tag_seen']==0)
		{
			//check out process
			$data="olduser";
			$msg = 2;
			//echo "<b>Status</b> : old user<br>";
			$sysname = $row['sys_allocated'];
			
			//update the given allocated system -> 0
			$conn = mysql_connect("localhost","root","");
			if (!$conn)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			mysql_select_db("ethernet", $conn);

			//echo "<b>Updating System Allocated</b><br>";
			//echo "User Allocated System is ".$sysname."<br>";
			
			mysql_query("UPDATE system_detail SET status = '0' WHERE sys_name = '$sysname'");
			//echo "Successfully updated - system deallocated<br>";
			//mysql_close($con);
			
			//echo "Updating Tag Seen<br>";
			
			//updating tag_seen -> 1
			
			$conn = mysql_connect("localhost","root","");
			if (!$conn)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			mysql_select_db("ethernet", $conn);

			mysql_query("UPDATE lab_checkin SET tag_seen = '1' WHERE rfid = '$uid'");
			mysql_query("UPDATE lab_checkin SET timeout = NOW() WHERE rfid = '$uid'");
			mysql_close($conn);
			//echo "Successfully updated - tag_seen is checked out<br>";
			break;
		}
	}
}
else
{
echo "error is ".mysqli_error($con);
}

if($data==null)
{
	$msg = 1;
	//echo "<b>Status</b> : new user<br>";
	//include ('getname.php');
	include ('allocate_system.php');
	$result = $_SESSION['result'];

	if($result == "success")
	{
		$con = mysql_connect("localhost","root","");
		if (!$con)
	  	{
	  		die('Could not connect: ' . mysql_error());
	  	}
		mysql_select_db("ethernet", $con);
		mysql_query("INSERT INTO lab_checkin (rfid,name,sys_allocated) VALUES ('$uid', '$name','$sysname')");
		//echo "Successfully Inserted<br>";

		mysql_close($con);
	}
}

//method that converts hex values into ascii or alphabetic values
function hex2str($hex) 
{
    $str = '';
    for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
    return $str;
    //echo "My Name is ".$str;
}

//sending response msg to arduino
if($msg==1)
{
	$status="success";
	$output="newuser";
	$system_info=$sysname;
	//$extra="labmonitor/arduino/response.php?status=".$status."&output=".$output."&system_info".$system_info;
	//header( 'Location: $extra' );
	echo "{\"status\": \"$status\",\"result\": \"$output\", \"system_info\": \"$system_info\"}";

}
else if($msg==2)
{
	$status="success";
	$output="olduser";
	$system_info="none";	
	//$extra="labmonitor/arduino/response.php?status=".$status."&output=".$output."&system_info".$system_info;
	//header( 'Location: $extra' );
	echo "{\"status\": \"$status\",\"result\": \"$output\", \"system_info\": \"$system_info\"}";
}
else
{
	$status="fail";
	$output="newuser";
	$system_info="no system available";
	//$extra="labmonitor/aduino/response.php?status=".$status."&output=".$output."&system_info".$system_info;
	//header( 'Location: $extra' );
	echo "{\"status\": \"$status\",\"result\": \"$output\", \"system_info\": \"$system_info\"}";

}

?>