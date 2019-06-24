<?php
session_start();
error_reporting(0);
if(isset($_GET['save']))
{
	$id=$_GET['labid'];
	$name=$_GET['labname'];
	$num_working_sys=$_GET['num_working_sys'];
	$num_non_working_sys=$_GET['num_non_working_sys'];

	include 'includes/connection.php';
	$update = "UPDATE lab_detail SET id='$id' , lab_name='$name' , num_working_sys='$num_working_sys', num_non_working_sys='$num_non_working_sys' WHERE id='$id'";
	if (mysqli_query($con, $update)) {
      //echo "Successfully Updated!!";
      $_SESSION['errmsg']="Successfully Updated!!";
   } else {
      echo "Error updating record: " . mysqli_error($con);
      $_SESSION['errmsg']="Error updating record: " . mysqli_error($con);
   }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>TEST POPUP</title>
	<link rel="stylesheet" type="text/css" href="popup.css">
	<style type="text/css">
		.errmsg{
			color: red;
			padding: 5px;
		}
	</style>

</head>
<body>
<div id="id01" class="modal">
    <span onclick="exit();" class="close" title="Close">&times;</span>
    <form class="modal-content" method="GET">
      <div class="container">
        <h2>Lab Information</h2>
        <p>Please provide changes if needed.</p>
        <hr>
        <span class="errmsg" >
        <?php echo htmlentities($_SESSION['errmsg']); ?>  
        <?php echo htmlentities($_SESSION['errmsg']="");?>
        </span>
        <?php
        if(isset($_GET['labid']))
        {
        	$id=$_GET['labid'];
	        include('includes/connection.php'); 
	        $query="SELECT * FROM lab_detail WHERE id='$id'";
	        if($res=mysqli_query($con,$query))
	        {
	          while($row=mysqli_fetch_array($res))
	          {
	            //echo $row['name'] ."<br>";
	        ?>
	        <br><br><label><b>Lab ID</b></label>
	        <input type="text" id="labid" name="labid" value="<?php echo $row['id'] ?>" readonly>
	        <label><b>Lab Name</b></label>
	        <input type="text" id="labname" name="labname" value="<?php echo $row['lab_name'] ?>">
	        <label><b>No of Working System</b></label>
	        <input type="text" id="num_working_sys" name="num_working_sys" value="<?php echo $row['num_working_sys'] ?>">
	        <label><b>No of Non Working System</b></label>
	        <input type="text" id="num_non_working_sys" name="num_non_working_sys" value="<?php echo $row['num_non_working_sys'] ?>">
	        
	    <?php    }
	        }
	        else
	        {
	          echo("Error description: " . mysqli_error($res));
	        } 
	    } ?>

        <div class="clearfix">
          <button type="button" onclick="exit();" class="cancelbtn">Cancel</button>
          <button type="submit" class="signupbtn" name="save" value="save" onclick="save();">Save</button>
        </div>
      </div>
    </form>
  </div>

<script type="text/javascript">
function PopUp(){
	document.getElementById('id01').style.display='block';
}
window.onload = function () {
    setTimeout(function () {
        PopUp('show');
    },500);
}

function exit(){
	document.getElementById('id01').style.display='none';
	window.location.href = "lab_detail1.php";
}

function save(){
	document.getElementById('id02').style.display='block';
}
</script>
</body>
</html>