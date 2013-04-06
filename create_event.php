<?php
require_once "_parts/functions.php";
require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>

<?php
if(isset($connection) && isset($_POST['submitEvent']))
{
	//insert a new event
	$event     = new Event($_POST);
	$eventType = strip_tags(trim($_POST['selectType']));
	//insert sessions for symposium
	if ($eventType =='SYMPOSIUM') {
		$event->insertSession($event->event_attr['session']);
	}

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
					.speaker-section{
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
							<input type="text" name = "sessionDesc" id="sessionDesc" placeholder="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="sessionSpeaker">Speaker:</label>
						<div class="controls">
							<input type="text" name = "sessionSpeaker" class = "typeahead" id="sessionSpeaker" >

							<button id="add-speaker" type = "button"></button>
							<button class="btn" id="create-speaker" type="button">Create Speaker</button>

						</div>
					</div>
					<div class="speaker-section">
						<div class="control-group">
							<label class="control-label" for="speaker-first">First Name:</label>
							<div class="controls">
								<input type="text" name = "speaker-first" id="speaker-first" placeholder="">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="speaker-last">Last Name:</label>
							<div class="controls">
								<input type="text" name = "speaker-last" id="speaker-last" placeholder="">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="speaker-prefix">Prefix:</label>
							<div class="controls">
								<input type="text" name = "speaker-prefix" id="speaker-prefix" placeholder="">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="speaker-title">Title:</label>
							<div class="controls">
								<input type="text" name = "speaker-title" id="speaker-title" placeholder="">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="speaker-dept">Department:</label>
							<div class="controls">
								<input type="text" name = "speaker-dept" id="speaker-dept" placeholder="">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="speaker-org">Organization:</label>
							<div class="controls">
								<input type="text" name = "speaker-org" id="speaker-org" placeholder="">
							</div>
						</div>
					</div>
					

					<div class="control-group">
						<label class="control-label" for="sessionType">Session Type:</label>
						<div class="controls">
							<select name = "sessionType" id = "sessionType" >
								<option value="1">Individual</option>
							</select>
						</div>
					
						<div class="controls">
						<button class="btn" id="add-session" type="button">Add Session</button>
						</div>
					</div>
				</div>
				<style type="text/css" media="screen">
					/*.event-session {
						margin-top: 10px;
						margin-bottom: 10px;
						border:1px solid silver;
					}*/
				</style>
		
				<script type="text/template" id="session-template" charset="utf-8">
					// <div class="event-session">
					// 	<input type='hidden' name='(session)(session_<%= session_num %>)session_desc' value='<%= desc %>' />
					// 	<input type='hidden' name='(session)(session_<%= session_num %>)session_type' value='<%= type %>' />
					// 	<span class="session-desc"><%= desc %></span>
					// 	<span class="session-speaker"><%= speaker %></span>
					// 	<span class ="session-type"><%= type %></span>
					// 	<a href="#" class="add-subsession">+</a>
					// </div>
				</script>
			
				
			
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

<?php require_once "_parts/html_foot.php";
