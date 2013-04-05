<?php
include("_parts/functions.php");
 include("_parts/connection.php");

// HTML parts
include("_parts/html_head.php");
include("_parts/header.php");
?>
<?php

class Event {

	public $event_attr = Array();
	public $id = NULL;

	public function __construct($post, $connection){
		$this->event_attr = PostParse($post);
		// print_r($this->event_attr);
		$this->insertEvent($this->event_attr);
		
	}
	public function insertEvent($attr){
		global $connection;
		$eventName         = strip_tags(trim($attr["eventName"]));
		$datepicker        = strip_tags(trim($attr["datepicker"]));
		$eventLoc          = strip_tags(trim($attr["eventLoc"]));
		$eventDesc         = strip_tags(trim($attr["Description"]));
		$eventType         = strip_tags(trim($attr["selectType"]));
		$eventStart        = strip_tags(trim($attr["eventStart"]));
		$eventEnd          = strip_tags(trim($attr["eventEnd"]));
		$eventContactName  = strip_tags(trim($attr["eventContactName"]));
		$eventContactEmail = strip_tags(trim($attr["eventContactEmail"]));
		$eventContactPhone = strip_tags(trim($attr["eventContactPhone"]));

		$sql1 = "INSERT INTO `tfscdb`.`event`
					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
					`Contact_Phone`)
					VALUES ('$eventName', '$datepicker', '$eventLoc', 
					'$eventType', '$eventDesc', '$eventStart', '$eventEnd', 
					'$eventContactName', '$eventContactEmail', 
					'$eventContactPhone');";
		$result = mysql_query($sql1, $connection) or die ("Could not excute sql $sql1");
		$this->id = mysql_insert_id($connection);
	}
	public function insertSession($sessions){
		global $connection;

		foreach ($sessions as $key => $session) {
			
			$sessionDesc = strip_tags(trim($sessions["sessionDesc"]));
			
	echo '<pre>';
	print_r($this->id);
	echo '</pre>';
			$sql2 = "INSERT INTO `tfscdb`.`session` (`Title`, `Event_ID`, `Group_Name`, `Order`) 
					VALUES ('$sessionDesc', '$this->id', 'example group', '1');";
	echo '<pre>';
	print_r($sql2);
	echo '</pre>';
					
			$result = mysql_query($sql2, $connection) or die ("Could not excute sql $sql2");
		}
	}

}
if(isset($connection) && isset($_POST['submitEvent']))
{
	$event = new Event($_POST, $connection);
	// echo '<pre>';
	// print_r($event->event_attr);
	// echo '</pre>';
	$event->insertSession($event->event_attr['session']);
	
	//$event->insertSession($event->event_attr);
}


?>

<div class="container">
	<div class="row">
		<div class="span3">
			<?php include("_parts/sidebar.php"); ?>
		</div>
		

		<!-- Form to post data-->
		<div class="span6 centerPlate">
			<!-- index body -->
			
			
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
					<label class="control-label" for="selectType">Event Type:</label>
					<div class="controls">
						<select name="selectType" id="selectType"> 
							<option value="select">--Select One--</option>
							<option value="TA">Teaching Assistant Luncheon</option>
							<option value="FACULTY">Luncheon</option>
							<option value="SYMPOSIUM">Symposium</option>
							<option value="RETREAT">Teaching Retreat</option>
						</select>
					</div>
				</div>
		
				<style type="text/css" media="screen">
					.break-section {
						display: none;
					}
					.event-section {
						display: none;
					}

				</style>
				<div class = "break-section">
					<div class="control-group">
						<label class="control-label" for="break-num">Breakout Session Number</label>
						<div class="controls">
							<select name = "break-num" id = "break-num" >
								<option value="0">--Select One--</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
					</div>
				</div>

				<div class="event-section">
					<div class="control-group">
						<label class="control-label" for="sessionDesc">Description:</label>
						<div class="controls">
							<input type="text" name = "(session)sessionDesc" id="sessionDesc" placeholder="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sessionSpeaker">Speaker:</label>
						<div class="controls">
							<input type="text" name = "(session)sessionSpeaker" id="sessionSpeaker" placeholder="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sessionType">Session Type:</label>
						<div class="controls">
							<select name = "(session)sessionType" id = "sessionType" >
								<option value="1">Individual</option>
							</select>
						</div>
					
						<div class="controls">
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
						<span class ="session-type"><%= type %></span>
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
			
			
			<!-- index body end -->
		</div>
	</div>
</div>