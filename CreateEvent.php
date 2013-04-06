<?php include("header.php");?>
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
        <h1>Create an Event</h1>
        <FORM id="form" name ="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">           
          </br>
            <table align="center" witdh="100%">
              <tr>
                <td colspan = "5">
                  Select an event type: 
                  <select name="selectType">
                    <option value="select">--Select One--</option>
                    <option value="TA">Teaching Assistant Luncheon</option>
                    <option value="FACULTY">New Faculty Luncheon</option>
                    <option value="FACULTY">All Faculty Luncheon</option>
                    <option value="SYMPOSIUM">Teaching Symposium</option>
                    <option value="RETREAT">Teaching Retreat</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
            </table>         
        </FORM> 
    </div>    
  </div>
</div>

</body>
</html>