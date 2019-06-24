<?php

include("includes/connection.php");

$sysname=" ";

$sql_select = "SELECT * FROM system_detail";
if($result=mysqli_query($con,$sql_select))
{
	while($row = mysqli_fetch_array($result))
	{
		if($row['status']==0)
		{
			$sysname = $row['sys_name'];
			//echo "My Free System is ".$sysname."<br>";
			$sql_update = "UPDATE system_detail SET status = '1' WHERE sys_name = '$sysname'";
			if(mysqli_query($con,$sql_update))
			{
			//echo "Successfully updated<br>";
			session_start();

			$result = "success";
			//$system_info = $sysname;

			$_SESSION['result'] = $result;
			//$_SESSION['system_info'] = $system_info;
			//echo "{\"result\": \"$result\", \"system_info\": \"$system_info\"}";

			mysqli_close($con);
			}
			else
			{
			echo "error is ".mysqli_error($con );
			}
			break;
		}
	}
}
else
{
echo "error is ".mysqli_error($con );
}
if($sysname == " ")
{
	//echo "Sorry!! No System Available";
	session_start();

	$msg = 3;

	$_SESSION['result'] = $result;
	//$_SESSION['system_info'] = $system_info;

}

?>