<?php  include("connection.php"); ?>
<?php include("header.php");

if($connection && isset($_POST['submitEvent']))
{
	$eventName 		= strip_tags(trim($_POST['eventName']));
	$datepicker 	= strip_tags(trim($_POST['datepicker']));
	$eventLoc 		= strip_tags(trim($_POST['eventLoc']));
	$eventDesc 		= strip_tags(trim($_POST['Description']));
	$eventType 		= strip_tags(trim($_POST['selectType']));
	$eventStart 	= strip_tags(trim($_POST['eventStart']));
	$eventEnd 		= strip_tags(trim($_POST['eventEnd']));
	$eventContactName 	= strip_tags(trim($_POST['eventContactName']));
	$eventContactEmail 	= strip_tags(trim($_POST['eventContactEmail']));
	$eventContactPhone 	= strip_tags(trim($_POST['eventContactPhone']));
	//Session Info
	$sessionDesc = strip_tags(trim($_POST['sessionDesc']));
	/*Validation for user input*/
	 if ($eventType == "select") {
	 	$typeErro = "Event type is not selected.<br>";
	 }
	// if(strlen($eventName) == 0){
	// 	$nameErro = "Event name cannot be empty.<br>";
	// }
	// if (strlen($eventLoc) == 0) {
	// 	$locErro = "Event location cannot be empty.<br>";
	// }
	// if (strlen($datepicker) == 0) {
	// 	$dateErro = "Event date cannot be empty.";
	// }
	if (isset($typeErro) != true)
	{
		if ($eventType == 'SYMPOSIUM') 
		{
			$sql1 = "INSERT INTO `tfscdb`.`event`
					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
					`Contact_Phone`)
					VALUES ('$eventName', '$datepicker', '$eventLoc', 
					'$eventType', '$eventDesc', '$eventStart', '$eventEnd', 
					'$eventContactName', '$eventContactEmail', 
					'$eventContactPhone');";
			$sql2 = "INSERT INTO `tfscdb`.`session` (`Description`, `Event_ID`) 
					VALUES ('$sessionDesc', last_insert_id());";
			if (mysql_query('BEGIN')) {
				if (mysql_query($sql1, $connection) && mysql_query($sql2, $connection))
				{
					mysql_query('COMMIT');
					$okmessage = "You have created an event successfully.";
				} // both queries looked OK, save
				else
				{
					mysql_query('ROLLBACK'); 
					// problems with queries, no changes
					$okmessage = "Event creating failed";
				}
			}
		}
		else
		{
			$sql = "INSERT INTO `tfscdb`.`event` 
					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
					`Contact_Phone`) 
					VALUES ('$eventName', '$datepicker', '$eventLoc', 
					'$eventType', '$eventDesc', '$eventStart', '$eventEnd', 
					'$eventContactName', '$eventContactEmail', '$eventContactPhone');";
			$result = mysql_query($sql, $connection) or die ("Could not excute sql $sql");
			$okmessage = "You have created an event successfully.";
		}
	 }
}
?>
        <h1 id="main-title">Create an Event</h1><br>
		
		<?php if ($okmessage) { ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Successful!</strong>
			<?php
			if (isset($typeErro) == ture) {
				echo $typeErro;
			}
			
			?>
		</div>
		<?php } ?>
		
		<form id="main-form" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<!-- event name -->
			<div class="control-group">
				<label class="control-label" for="eventName">Event Name:</label>
				<div class="controls">
					<input type="text" name = "eventName" id="eventName"  placeholder="" required>
				</div>
			</div>
			<!-- date -->
			<div class="control-group">
				<label class="control-label" for="datepicker">Date:</label>
				<div class="controls">
					<input type="text" id="datepicker" placeholder="">
				</div>
			</div>
			<!-- location -->
			<div class="control-group">
				<label class="control-label" for="eventLoc">Location:</label>
				<div class="controls">
					<input type="text" id="eventLoc" placeholder="">
				</div>
			</div>
			<!-- desc -->
			<div class="control-group">
				<label class="control-label" for="Description">Description:</label>
				<div class="controls">
					<textarea name="Description" rows="3"></textarea>
				</div>
			</div>
			<!-- type -->
			<div class="control-group">
				<label class="control-label" for="sessionDesc">Event Type:</label>
				<div class="controls">
					<select name="selectType" id="selectType"> 
						<option value="select">--Select One--</option>
						<option value="TA">Teaching Assistant Luncheon</option>
						<option value="FACULTY">New Faculty Luncheon</option>
						<option value="FACULTY">All Faculty Luncheon</option>
						<option value="SYMPOSIUM">Teaching Symposium</option>
						<option value="RETREAT">Teaching Retreat</option>
					</select>
				</div>
			</div>
		
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
			</div>
			<style type="text/css" media="screen">
				.event-session {
					margin-top: 10px;
					margin-bottom: 10px;
					border:1px solid silver;
				}
			</style>
		
			<script type="text/template" id="session-template" charset="utf-8">
				<div class="event-session">
					<span class="session-desc"><%= desc %></span>
					<span class="session-speaker"><%= speaker %></span>
					<a href="#" class="add-subsession">+</a>
				</div>
			</script>
			
			<div class="control-group">
				<label class="control-label" for="eventStart">Start Time:</label>
				<div class="controls">
					<input type="text" id="eventStart" placeholder="">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="eventEnd">End Time:</label>
				<div class="controls">
					<input type="text" id="eventEnd" placeholder="">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="eventContactName">Contact Name:</label>
				<div class="controls">
					<input type="text" id="eventContactName" placeholder="">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="eventContactEmail">Contact Email:</label>
				<div class="controls">
					<input type="text" id="eventContactEmail" placeholder="">
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="eventContactPhone">Contact Phone:</label>
				<div class="controls">
					<input type="text" id="eventContactPhone" placeholder="">
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<button class="btn" type="submit" name ='submitEvent'>Add Event</button>
				</div>
			</div>
		</form>
<?php include("footer.php");
