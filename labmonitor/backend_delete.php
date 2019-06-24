<?php

if(isset($_GET['labid']))
{
	$labid = $_GET['labid'];
	include("includes/connection.php");
	$delete = "DELETE FROM lab_detail WHERE id='$labid'";
	if(mysqli_query($con,$delete)){
		echo "Successfully Deleted!!";
	}
	else{
		echo "Error updating record: " . mysqli_error($con);
	}
}

?>