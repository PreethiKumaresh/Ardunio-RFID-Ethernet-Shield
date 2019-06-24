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
      <h1>Welcome to Lab Monitoring System</h1><br>
    </div>
      <article>
        <h3>WHAT?</h3><br>
        <p><b>Lab Monitoring System</b> is a device that monitors the data of all the people who are using the computer Lab.</p><br>
        <h3>WHY?</h3><br>
        <p>To manage the lab security in terms of the problems like device theft, physical damage to hardware and also to keep track of the list of persons utilizing the lab.</p><br>
        <h3>HOW?</h3><br>
        <p>Using <b>RFID - Radio Frequency Identification</b> tag. RFID is a small wireless tag that help to identify objects and people. These tags do not require a battery to power up and in turn, they derive power from the electromagnetic field generated from the RFID reader with the help of Arduino Uno.<br><b style="padding-left: 50px;">Arduino Uno</b> is a microcontroller board based on ATmega328 that is mainly capable of running one program at a time, over and over again which connected over ethernet.That helps to read the RFID UID present in student’s ID card where information about the user is updated in the database and analyzed for future use</p>
      </article>
  </section>
  <!--<footer>
    <h3 class="footer">Copyright &copy; 2019, MK Preethi of Stella Maris College II MSc IT</h3> 
  </footer>-->

</body>
</html>