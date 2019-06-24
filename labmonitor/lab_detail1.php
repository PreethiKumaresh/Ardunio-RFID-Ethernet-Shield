<?php session_start();
error_reporting(0);
if(isset($_POST['add'])) {
  $id=$_POST['labid'];
  $name=$_POST['labname'];
  $working_sys=$_POST['working_sys'];
  $non_working_sys=$_POST['non_working_sys'];
  include("includes/connection.php");
  $query="INSERT INTO lab_detail (id,lab_name,num_working_sys,num_non_working_sys) VALUES ('$id','$name','$working_sys','$non_working_sys')";
  if(mysqli_query($con,$query))
  {
    //echo "Affected rows: " . mysqli_affected_rows($con);  
    if(mysqli_affected_rows($con)>0)
    {
      //echo "<br><div class='successmsg'>SUCCESSFULLY REGISTERED!!</div>";
      //$_SESSION['errmsg']="Successfully Added!!";
    }
  }
  else
  {
    //echo("Error description: " . mysqli_error($con));     
    $_SESSION['errmsg']="Error description: " . mysqli_error($con);
  }
}
if(isset($_GET['del']))
{
  $labid = $_GET['labid'];
  include("includes/connection.php");
  $delete = "DELETE FROM lab_detail WHERE id='$labid'";
  if(mysqli_query($con,$delete)){
    //echo "Successfully Deleted!!";
    echo '<script>alert("Successfully Deleted!!");</script>';
  }
  else{
    echo "Error updating record: " . mysqli_error($con);
    echo '<script>alert("Error in connection");</script>';
  }
}  
?>
<html>
<head>
  <title>Administration</title>
  <link rel="stylesheet" href="https://use.typekit.net/wqe7gdm.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="lab_detail_style.css">
  <style type="text/css">

  </style>
</head>
<body>
  <header><h2>Lab Monitoring System <i class="fas fa-user" style="padding-left: 900px;
    font-size: 20px;">   Welcome Admin</i></h2></header>
  <section class="menu">
    <nav>
      <a class="sidebar" href="home.php" class="menu-items">Home</a>
      <a class="sidebar" href="lab_detail1.php" class="menu-items">Lab Detail</a>
      <!--<a href="lab_user_detail.php" class="menu-items">Lab User Detail</a>-->
      <a class="sidebar" href="test.php" class="menu-items">Lab User Detail</a>
      <a class="sidebar" href="system_detail.php" class="menu-items">System Details</a>
      <a class="sidebar" href="report.php" class="menu-items" target="_blank">Generate Report</a>
      <a class="sidebar" href="index.html" class="menu-items">Logout</a>
    </nav>
  </section>

  <section class="menu-content">
    <div align="center">
      <h1>Computer Lab Details</h1><br>
      <form method="post">
        <table border="0">
          <tr>
            <td>Lab ID:</td>
            <td><input type="text" name="labid" required></td>
            <td>Lab Name:</td>
            <td><input type="text" name="labname" required></td>
          </tr>
          <tr>
            <td>Working System:</td>
            <td><input type="text" name="working_sys" pattern="[0-9]+" required></td>
            <td>Non Working System:</td>
            <td><input type="text" name="non_working_sys" pattern="[0-9]+" required></td>
          </tr>
        </table>
        <input type="submit" name="add" id="add" value="ADD" style="width: 100px;"><br>
        <span class="errmsg" >
          <b><?php echo htmlentities($_SESSION['errmsg']); ?>  
          <?php echo htmlentities($_SESSION['errmsg']="");?></b>
          </span>
      </form>
      <!--<div class="result" style="color:red;padding: 10px;"></div>-->
      <?php
        include("includes/connection.php");

        $select =mysqli_query($con,"SELECT * FROM lab_detail");
        ?>
        <br><table border="1" id="user_table">
        <tr>
        <th>Lab ID</th>
        <th>Lab Name</th>
        <th>No of Working </th>
        <th>No of Non Working System</th>
        <th>Action</th>
        </tr>
        <?php
        while ($row=mysqli_fetch_array($select)) 
        {
         ?>
         <tr>
          <td><?php echo $row['id'];?></td>
          <td><?php echo $row['lab_name'];?></td>
          <td><?php echo $row['num_working_sys'];?></td>
          <td><?php echo $row['num_non_working_sys'];?></td>
          <td>
           <button style="width:auto;" id="<?php echo $row['id'];?>" 
            onclick="edit(this.id);" value="<?php echo $row['id'];?>">Edit</button>
            <!--<button style="width:auto;" id="<?php echo $row['id'];?>" 
            onclick="Delete(this.id);" value="<?php echo $row['id'];?>">Delete</button>-->
            <a class=".delete" href="lab_detail1.php?labid=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
              <button style="width:auto;">Delete</button>
            </a>
          </td>
         </tr>
         <?php
        }
        ?>
        </table>
    </div>
  </section>
  <!--<footer>
    <h3 class="footer">Copyright &copy; 2019, MK Preethi of Stella Maris College II MSc IT</h3> 
  </footer>-->
  <script>
function edit(clicked_id)
{
    window.location.href = "test_popup.php?labid="+clicked_id;
}
/*function Delete(clicked_id)
{
  alert(clicked_id);
  var labid=clicked_id;
  var mydata="labid="+labid;
  $.ajax({
      type: "GET",
      url: 'backend_delete.php',
      data: mydata,
      success: function(data){
          //$(".result").html(data);
          //alert(data); 
          if(data.success == true){ // if true (1)
          setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000); 
        }
      }
  });
}*/
</script>
</body>
</html>