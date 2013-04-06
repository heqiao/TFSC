<?php 
include("header.php");
  $connection = mysql_connect("localhost","root", "");
    mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
      
    mysql_close();
?>
<!doctype html>
<html lang="en">
<head></head>
<body>
<div class="container">
  <div class="row">
    <div class="threecol">
      <!--  Left Sidebar -->
      <ul id="leftNav">            
         <li><a href="CreateEvent.php">Create Event</a></li>      
         <li><a href="GenerateReport.php">Generate Reports</a></li>
         <li><a href="#">RSVP System</a></li>       
         <li><a href="#">Download Data</a></li> 
        </ul>
    </div>
    <!-- Form to post data-->
    <div class="sixcol centerPlate">
        
    </div>    
  </div>
</div>

</body>
</html>