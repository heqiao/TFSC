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
  $eventDesc =  strip_tags(trim($_POST['Description']));
  $eventType =  strip_tags(trim($_POST['selectType']));
  $eventStart =  strip_tags(trim($_POST['eventStart']));
  $eventEnd =  strip_tags(trim($_POST['eventEnd']));
  $eventContactName =  strip_tags(trim($_POST['eventContactName']));
  $eventContactEmail =  strip_tags(trim($_POST['eventContactEmail']));
  $eventContactPhone =  strip_tags(trim($_POST['eventContactPhone']));
  //Session Info
  $sessionDesc = strip_tags(trim($_POST['sessionDesc']));
  /*Validation for user input*/
  if ($eventType == "select") {
    $typeErro = "Event type is not selected.<br>";
  }
  if(strlen($eventName) == 0){
    $nameErro = "Event name cannot be empty.<br>";
  }
  if (strlen($eventLoc) == 0) {
    $locErro = "Event location cannot be empty.<br>";
  }
  if (strlen($datepicker) == 0) {
    $dateErro = "Event date cannot be empty.";
  }
  
  if (isset($typeErro) != true && isset($nameErro) != true && isset($locErro) != true && isset($dateErro) != true ) {
    
    if ($eventType == 'SYMPOSIUM') {
     
      $sql1 = "INSERT INTO `tfscdb`.`event` 
        (`Name`, `Date`, `Location`, `Event_Type`, `Description`, `Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, `Contact_Phone`) 
        VALUES ('$eventName', '$datepicker', '$eventLoc', '$eventType', 'Description', '$eventStart', '$eventEnd', '$eventContactName', '$eventContactEmail', '$eventContactPhone');";
      $sql2 = " INSERT INTO `tfscdb`.`session` (`Description`, `Event_ID`) VALUES ('$sessionDesc', last_insert_id());";
      
      if (mysql_query('BEGIN')) {
          if (mysql_query($sql1, $connection) &&
              mysql_query($sql2, $connection)){
              mysql_query('COMMIT');
              $okmessage = "You have created an event successfully.";
              } // both queries looked OK, save
          else{
              mysql_query('ROLLBACK'); // problems with queries, no changes
              $okmessage = "Event creating failed";
              }
      }
    }
    else{
      
         $sql = "INSERT INTO `tfscdb`.`event` 
        (`Name`, `Date`, `Location`, `Event_Type`, `Description`, `Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, `Contact_Phone`) 
        VALUES ('$eventName', '$datepicker', '$eventLoc', '$eventType', 'Description', '$eventStart', '$eventEnd', '$eventContactName', '$eventContactEmail', '$eventContactPhone');";
        
        $result = mysql_query($sql, $connection) or die ("Could not excute sql $sql");
        $okmessage = "You have created an event successfully.";
        }
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
        <FORM id="form" name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">           
        <label>Event Name: </label> <input type = "text" name = "eventName"><br>
        <label>Date: </label> <input type = "text" name = "datepicker" id = "datepicker"><br>
        <label>Location:</label> <input type = "text" name = "eventLoc"><br>
        <label>Description:</label><textarea name = "Description" rows="3"></textarea><br>
        <label>Event Type:</label>
		<select name="selectType" id="selectType"> 
			<option value="select">--Select One--</option>
			<option value="TA">Teaching Assistant Luncheon</option>
			<option value="FACULTY">New Faculty Luncheon</option>
			<option value="FACULTY">All Faculty Luncheon</option>
			<option value="SYMPOSIUM">Teaching Symposium</option>
			<option value="RETREAT">Teaching Retreat</option>
		</select>
		<br />
		
		<style type="text/css" media="screen">
		.event-section {
			display: none;
		}
		</style>
		<div class="event-section">
			<div class="control-group">
				<label class="control-label" for="sessionDesc">Description:</label>
				<div class="controls">
					<input type="text" id="sessionDesc" placeholder="">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="sessionSpeaker">Speaker:</label>
				<div class="controls">
					<input type="text" id="sessionSpeaker" placeholder="">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
						<input id="break-out-session" type="checkbox"> This is a break out session
					</label>
					<button class="btn" id="add-session" type="button">Add Session</button>
				</div>
			</div>
			
			
			<!-- <div id="sessionId">
				<label>Description: </label>
				<input type="text" name="sessionDesc" id="sessionDesc"> <br>
				<label>Speaker: </label>
				<input type="text" name="speaker" id="sessionSpeaker"> <br>
				<button class="btn" id="sessionSubmit" type="button">Add Session</button></div> -->
		</div>
		<style type="text/css" media="screen">
		.event-session {
			margin-top: 10px;
			background-color: blue;
		}
		</style>
		
		<script type="text/template" id="session-template" charset="utf-8">
			<div class="event-session">
				<span class="session-desc"><%= desc %></span>
				<span class="session-speaker"><%= speaker %></span>
				<a href="#" class="add-subsession">+</a>
			</div>
		</script>
		
		<br />
		
		
		
        <label>Start Time: </label> <input type = "text" name = "eventStart"><br>
        <label>End Time: </label> <input type = "text" name = "eventEnd"><br>
         <label>Contact Name: </label> <input type = "text" name = "eventContactName"><br>
         <label>Contact Email: </label> <input type = "text" name = "eventContactEmail"><br>
          <label>Contact Phone: </label> <input type = "text" name = "eventContactPhone"><br>
          <button class="btn" type="submit" name ='submitEvent'>Add Event</button><br>
           <div class="alert alert-success">
            <?php
            
            if (isset($typeErro) == ture) {
             echo $typeErro;
            }
            if (isset($nameErro) == ture) {
             echo $nameErro;
            }
            if (isset($locErro) == ture) {
             echo $locErro;
            }
            if (isset($dateErro) == ture) {
             echo $dateErro;
            }
            if (isset($okmessage) == true) {
               echo $okmessage;
            }
               
            
         
            ?>
            </div>
        </FORM> 
    </div>    
  </div>
</div>

</body>
</html>