<?php
$url=$_SERVER['REQUEST_URI'];
header("Refresh: 10; URL=$url"); // Refresh the webpage every 5 seconds
?>
<html>
<head>
  <title>Administration</title>
  <link rel="stylesheet" href="https://use.typekit.net/wqe7gdm.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <style type="text/css">
  input[type=submit]{
  background-color: #2c50a3;
  color: white;
  padding: 10px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 10%;
  opacity: 0.9;
  border-radius: 10px;
}
input[type=submit]:hover {
  opacity:1;
}
  </style>
</head>
<body>
  <header><h2>Lab Monitoring System <i class="fas fa-user" style="padding-left: 900px;
    font-size: 20px;">  Welcome Admin</i></h2></header>
  <section class="menu">
    <nav>
      <a href="home.php" class="menu-items">Home</a>
      <a href="lab_detail1.php" class="menu-items">Lab Detail</a>
      <!--<a href="lab_user_detail.php" class="menu-items">Lab User Detail</a>-->
      <a href="test.php" class="menu-items">Lab User Detail</a>
      <a href="system_detail.php" class="menu-items">System Details</a>
      <a href="report.php" class="menu-items" target="_blank">Generate Report</a>
      <a href="index.html" class="menu-items">Logout</a>
    </nav>
  </section>

  <section class="menu-content">
    <div align="center">
      <h1>Details of the users who are currently using the lab</h1><br>
      <p align="right" style="padding-right: 150px;color: red"><b>* Status: 0-Entered 1-Exited</b></p>
      <br>
      <form>
    <!--    <table>
          <tr>
            <td>Date:</td>
            <td><input type="date" name="date" id="date"></td>
            <td>Name:</td>
            <td><input type="text" name="name" id="name"></td>
            <td>System:</td>
            <td><input type="text" name="sysname" id="sysname"></td>
            <td><input type="submit" name="search" value="Search"></td>
          </tr>
        </table>  -->
        <div align="right" style="margin-right: 150px;">
        <span>    
            <label>System:</label>
            <input type="text" name="sysname" id="sysname" autocomplete="off">
            <input type="submit" name="search" value="Search">
        </span>
      </div>
      </form><br>
      <?php
      if(isset($_GET['search']))
      {
        //$date=$_GET['date'];
        //$name=$_GET['name'];
        $sysname=$_GET['sysname'];
        if(/*$date!=null || $name!=null ||*/ $sysname!=null)
        {
          $Tformat="%h:%i %p";
        include("includes/connection.php");
          /*$query="SELECT DATE_FORMAT(mydate,'%m-%d-%Y') mydate, rfid,name,sys_allocated,TIME_FORMAT(timein,'$Tformat') timein,TIME_FORMAT(timeout,'$Tformat') timeout,tag_seen FROM lab_checkin WHERE name='$name' OR sys_allocated='$sysname' OR mydate='$date'";*/
          $query="SELECT DATE_FORMAT(mydate,'%m-%d-%Y') mydate, rfid,name,sys_allocated,TIME_FORMAT(timein,'$Tformat') timein,TIME_FORMAT(timeout,'$Tformat') timeout,tag_seen FROM lab_checkin WHERE sys_allocated='$sysname'";

          if($result = mysqli_query($con, $query))
          {
            if (mysqli_num_rows($result) > 0) 
            {?>
              <table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td class="table_titles">Date</td>
                    <td class="table_titles">RFID</td>
                    <td class="table_titles">NAME</td>
                    <td class="table_titles">SYSTEM ALLOCATED</td>
                    <td class="table_titles">TIME IN</td>
                    <td class="table_titles">TIME OUT</td>
                    </tr>
             <?php while($row = mysqli_fetch_assoc($result)) 
              {?>
                
                  <tr>
                    <td><?php echo $row['mydate']?></td>
                    <td><?php echo $row['rfid']?></td>
                    <td><?php echo $row['name']?></td>
                    <td><?php echo $row['sys_allocated']?></td>
                    <td><?php echo $row['timein']?></td>
                    <td><?php echo $row['timeout']?></td>
                  </tr>
            <?php    
                } ?>
                 </table><br>
          <?php  }
          else{
            echo "<script>alert('No Record Found!!');</script>";
            } 
          }
          }
         }
        ?>

      <table border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td class="table_titles">SNo</td>
      <td class="table_titles">DATE</td>
      <td class="table_titles">RFID</td>
      <td class="table_titles">NAME</td>
      <td class="table_titles">SYSTEM ALLOCATED</td>
      <td class="table_titles">TIME IN</td>
      <td class="table_titles">TIME OUT</td>
      <td class="table_titles">STATUS</td>
      </tr>
    <?php
      $con = mysql_connect("localhost","root","");
      if (!$con)
        {
        die('Could not connect: ' . mysql_error());
        }

      $count = 1;
      mysql_select_db("ethernet", $con);
      $Tformat="%h:%i %p";
      //$Dformat="%y-%m-%d";
      $result = mysql_query("SELECT DATE_FORMAT(mydate,'%d-%m-%Y') mydate, rfid,name,sys_allocated,TIME_FORMAT(timein,'$Tformat') timein,TIME_FORMAT(timeout,'$Tformat') timeout,tag_seen FROM lab_checkin");
      while($row = mysql_fetch_array($result))
      {
        
          echo "<tr>";
          echo "<td>" . $count . "</td>";
          echo "<td>" . $row['mydate'] . "</td>";
          echo "<td>" . $row['rfid'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['sys_allocated'] . "</td>";
          echo "<td>" . $row['timein'] . "</td>";
           echo "<td>" . $row['timeout'] . "</td>";
          echo "<td>" . $row['tag_seen'] . "</td>";
          echo "</tr>"; 
          $count ++;
      }
      mysql_close($con);  
    ?>
  </table>
    </div>
  </section>
  <!--<footer>
    <h3 class="footer">Copyright &copy; 2019, MK Preethi of Stella Maris College II MSc IT</h3> 
  </footer>-->

</body>
</html>