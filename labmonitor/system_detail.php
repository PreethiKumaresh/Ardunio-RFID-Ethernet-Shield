<html>
<head>
  <title>Administration</title>
  <link rel="stylesheet" href="https://use.typekit.net/wqe7gdm.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h2>Lab Monitoring System <i class="fas fa-user" style="padding-left: 900px;
    font-size: 20px;">   Welcome Admin</i></h2></header>
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
      <h1>System Availability Detail</h1><br>
      <p align="right" style="padding-right: 150px;color: red"><b>* Status: 0-Available 1-Not Available(in-use)</b></p><br>
      <table border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td class="table_titles">SNo</td>
      <td class="table_titles">SYSTEM NAME</td>
      <td class="table_titles">STATUS</td>
      </tr>
    <?php
      $con = mysql_connect("localhost","root","");
      if (!$con)
        {
        die('Could not connect: ' . mysql_error());
        }
      $oddrow = true;
      $count = 1;
      mysql_select_db("ethernet", $con);
      $result = mysql_query("SELECT * FROM system_detail");
      while($row = mysql_fetch_array($result))
      {
        if ($oddrow)
          {
            $css_class=' class="table_cells_odd"';
          }
          else
          {
            $css_class=' class="table_cells_even"';
          }
          $oddrow = !$oddrow; 
          echo "<tr>";
          echo "<td '.$css_class.'>" . $count . "</td>";
          echo "<td '.$css_class.'>" . $row['sys_name'] . "</td>";
          echo "<td '.$css_class.'>" . $row['status'] . "</td>";
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