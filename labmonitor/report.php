<?php  
 function fetch_data()  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "ethernet");  
      $sql = "SELECT * FROM lab_detail ORDER BY id ASC";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                          <td>'.$row["id"].'</td>  
                          <td>'.$row["lab_name"].'</td>  
                          <td>'.$row["num_working_sys"].'</td>  
                          <td>'.$row["num_non_working_sys"].'</td>  
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["create_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Lab Information Report");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '4', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 12);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h3 align="center">Information List Regarding Computer Lab Details</h3><br /><br />  
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th>ID</th>  
                <th>Lab Name</th>  
                <th>Working System</th>  
                <th>Non-Working System</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('sample.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Generate PDF</title>  
           <title>Administration</title>
            <link rel="stylesheet" href="https://use.typekit.net/wqe7gdm.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
            <link rel="stylesheet" href="style.css">       
            <style type="text/css">
              input[type="submit"]{
                background-color: #ffbc4b; 
                border:none; 
                border-radius: 20px; 
                padding: 20px; 
                cursor: pointer;
                font-weight: bold;
              }
            </style>    
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
      <a href="report.php" class="menu-items">Generate Report</a>
      <a href="index.html" class="menu-items">Logout</a>
    </nav>
  </section>

  <section class="menu-content">
    <br /><br />  
           <div class="container" align="center">  
                <h3 align="center">Information List Regarding Computer Lab Details</h3><br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th>ID</th>  
                               <th>Lab Name</th>  
                               <th>Working System</th>  
                               <th>Non-Working System</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table>  
                     <br />  
                     <form method="post">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Generate PDF" />  
                     </form>  
                </div>  
           </div>
  </section>  
      </body>  
 </html>  