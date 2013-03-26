<?php include("header.php");
if(isset($_POST['submitEvent']))
  {
    //Connection string 
  $connection = mysql_connect("localhost","root", "");
  //Run the connection string to connecct to the databse
  mysql_select_db("tfscdb", $connection) or die("Cannot open the database");

  $eventName =  strip_tags(trim($_POST['eventName']));
  $datepicker =  strip_tags(trim($_POST['datepicker']));
  $eventLoc =  strip_tags(trim($_POST['eventLoc']));
  $eventType =  strip_tags(trim($_POST['selectType']));
  $eventStart =  strip_tags(trim($_POST['eventStart']));
  $eventEnd =  strip_tags(trim($_POST['eventEnd']));
  $eventContactName =  strip_tags(trim($_POST['eventContactName']));
  $eventContactEmail =  strip_tags(trim($_POST['eventContactEmail']));
  $eventContactPhone =  strip_tags(trim($_POST['eventContactPhone']));

  if (strlen(trim($eventName)) == 0) {
    $nameErro = "Event Name cannot be empty.<br>";
  }
  if (!isset($nameErro)) {
    $sql = "INSERT INTO `tfscdb`.`event` 
    (`Name`, `Date`, `Location`, `Event_Type`, `Description`, `Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, `Contact_Phone`) 
    VALUES ('$eventName', '$datepicker', '$eventLoc', '$eventType', 'ssssssssss', '$eventStart', '$eventEnd', '$eventContactName', '$eventContactEmail', '$eventContactPhone');";

          $result = mysql_query($sql, $connection) or die ("Could not excute sql $sql");
          $okmessage = "You have created an event successfully.";
         
         
    }

    mysql_close(); 
    
    }
?>

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
    <div id = "eventDiv">
        <h1>Create an Event</h1><br>
        <FORM id="form" name ="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">           
        <label>Event Name: </label> <input type = "text" name = "eventName"><br>
        <label>Date: </label> <input type = "text" name = "datepicker" id = "datepicker"><br>
        <label>Location:</label> <input type = "text" name = "eventLoc"><br>
        <label>Description:</label><textarea rows="3"></textarea><br>
        <label>Event Type:</label> <select name = "selectType" id="selectType"> 
                    <option value="select">--Select One--</option>
                    <option value="TA">Teaching Assistant Luncheon</option>
                    <option value="FACULTY">New Faculty Luncheon</option>
                    <option value="FACULTY">All Faculty Luncheon</option>
                    <option value="SYMPOSIUM">Teaching Symposium</option>
                    <option value="RETREAT">Teaching Retreat</option>
                  </select>
                </br>
        <label>Start Time: </label> <input type = "text" name = "eventStart"><br>
        <label>End Time: </label> <input type = "text" name = "eventEnd"><br>
         <label>Contact Name: </label> <input type = "text" name = "eventContactName"><br>
         <label>Contact Email: </label> <input type = "text" name = "eventContactEmail"><br>
          <label>Contact Phone: </label> <input type = "text" name = "eventContactPhone"><br>
          <button class="btn" type="submit" name ='submitEvent'>Add Event</button><br>
           <div class="alert alert-success">
            <?php
            if($okmessage)
          {
            echo $okmessage;
          }
            ?>
            </div>
<!-- 
            <table id = 'eventtable' align="center" witdh="100%">
              <tr>
                <td >Event Name:</td>
                <td><input type = "text" name = "eventName"></td>
              </tr>
              <tr>
                <td>Date:</td>
                <td><input type = "text" id = "datepicker"></td>
              </tr>
              <tr>
                <td>Location:</td>
                <td><input type = "text" name = "eventLocation"></td>
              </tr>
              <tr id = "eventTypeRow">
                <td>Event Type:</td>
                <td>
                  <select id="selectType">
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
                <td>Start Time:</td>
                <td><input type = "text" name = "eventStart"></td>
              </tr>
              <tr>
                <td>End Time:</td>
                <td><input type = "text" name = "eventEnd"></td>
              </tr>
            </table > 
           <div id = "symdiv"> 
              <table align="center" witdh="100%">
              <tr>
                <td>Session Name:</td>
                <td><input type = "text" name = "sessionName"></td>
              </tr>
              <tr>
                <td>Speaker:</td>
                <td><input type = "text" name = "speakerName"></td>
              </tr>
              <tr>
                <td>Start Time:</td>
                <td><input type = "text" name = "sessionStart"></td>
              </tr>
                <tr>
                  <td>End Time:</td>
                  <td><input type = "text" name = "sessionEnd"></td>
                </tr>
              <tr>
                <td>Session Description:</td>
                <td><input type = "text" name = "sessionDesc"></td>
              </tr>
              </table>
            </div>
 
        Event Name: <input type = "text" name = "eventname"><br>
        Date: <input type = "text" id = "datepicker"><br>
        Select a type:
                  <select id="selectType">
                    <option value="select">--Select One--</option>
                    <option value="TA">Teaching Assistant Luncheon</option>
                    <option value="FACULTY">New Faculty Luncheon</option>
                    <option value="FACULTY">All Faculty Luncheon</option>
                    <option value="SYMPOSIUM">Teaching Symposium</option>
                    <option value="RETREAT">Teaching Retreat</option>
                  </select>
-->
        </FORM> 
    </div>    
  </div>
</div>

</body>
</html>