<?php
require_once "_parts/functions.php";
require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>

<?php

// class Event {

// 	public $event_attr = Array();
// 	public $id = NULL;

// 	public function __construct($post, $connection){
// 		$this->event_attr = PostParse($post);
// 		// print_r($this->event_attr);
// 		$this->insertEvent($this->event_attr);
		
// 	}
// 	public function insertEvent($attr){
// 		global $connection;
// 		$eventName         = strip_tags(trim($attr["eventName"]));
// 		$datepicker        = strip_tags(trim($attr["datepicker"]));
// 		$eventLoc          = strip_tags(trim($attr["eventLoc"]));
// 		$eventDesc         = strip_tags(trim($attr["Description"]));
// 		$eventType         = strip_tags(trim($attr["selectType"]));
// 		$eventStart        = strip_tags(trim($attr["eventStart"]));
// 		$eventEnd          = strip_tags(trim($attr["eventEnd"]));
// 		$eventContactName  = strip_tags(trim($attr["eventContactName"]));
// 		$eventContactEmail = strip_tags(trim($attr["eventContactEmail"]));
// 		$eventContactPhone = strip_tags(trim($attr["eventContactPhone"]));

// 		$sql1 = "INSERT INTO `tfscdb`.`event`
// 					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
// 					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
// 					`Contact_Phone`)
// 					VALUES ('$eventName', '$datepicker', '$eventLoc', 
// 					'$eventType', '$eventDesc', '$eventStart', '$eventEnd', 
// 					'$eventContactName', '$eventContactEmail', 
// 					'$eventContactPhone');";
// 		$result = mysql_query($sql1, $connection) or die ("Could not excute sql $sql1");
// 		$this->id = mysql_insert_id($connection);
// 	}
// 	public function insertSession($sessions){
// 		global $connection;

// 		foreach ($sessions as $key => $session) {
			
// 			$sessionDesc = strip_tags(trim($sessions["sessionDesc"]));
			
// 	echo '<pre>';
// 	print_r($this->id);
// 	echo '</pre>';
// 			$sql2 = "INSERT INTO `tfscdb`.`session` (`Title`, `Event_ID`, `Group_Name`, `Order`) 
// 					VALUES ('$sessionDesc', '$this->id', 'example group', '1');";
// 	echo '<pre>';
// 	print_r($sql2);
// 	echo '</pre>';
					
// 			$result = mysql_query($sql2, $connection) or die ("Could not excute sql $sql2");
// 		}
// 	}

// }
if(isset($connection) && isset($_POST['submitEvent']))
{
	$event = new Event($_POST, $connection);
	// echo '<pre>';
	// print_r($event->event_attr);
	// echo '</pre>';
	$event->insertSession($event->event_attr['session']);
}


?>

<div class="container">
	<div class="row">
		<div class="span3">
			<?php include("_parts/sidebar.php"); ?>
		</div>
		
		<div class = "span9">
			<div class="tabbable"> <!-- Only required for left/right tabs -->
			  <ul class="nav nav-tabs">
			    <li class="active"><a href="#tab-ta" data-toggle="tab">TA Luncheon</a></li>
			    <li><a href="#tab-luncheon" data-toggle="tab">Luncheon</a></li>
			    <li><a href="#tab-symposium" data-toggle="tab">Symposium</a></li>
			    <li><a href="#tab-retreat" data-toggle="tab">Teaching Retreat</a></li>
			    <li><a href="#tab-orientation" data-toggle="tab">Orientation</a></li>
			   </ul>
			  <div class="tab-content">
			  	<!-- First tab for TA luncheon-->
			    <div class="tab-pane active" id="tab-ta">
			    	<form id="main-form" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php include("_parts/event_form.php"); ?> 
					</form>	    	 
			    </div>
			    <!-- Second tab for luncheon-->
			    <div class="tab-pane active" id="tab-luncheon">
			     	<form id="main-form" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php include("_parts/event_form.php"); ?> 
					</form>
			    </div>
			    <!-- Third tab for symposium-->
			    <div class="tab-pane" id="tab-symposium">
			    	
			    	<form id="main-form-symposium" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class ="row-fluid">
							<!-- Left part of the form -->
							<div class ="span6">
								<?php include("_parts/event_form.php"); ?>
							</div>
							<!-- Right part of the form -->
							<div class = "span6">
								<div class="controls">
									<button class="btn" id="new-session" type="button">Add Session</button>
									<button class="btn" id="new-breakout" type="button">Add Breakout Session</button>
								</div>
							</div>
							<!--  -->
							<style type="text/css" media="screen">
								.event-session {
									margin-top: 10px;
									margin-bottom: 10px;
									border:1px solid silver;
								}
							</style>
			
							<script type="text/template" id="session-template-symp" charset="utf-8">
								<div class="event-session">
									// <input type='hidden' name='(session)(session_<%= session_num %>)session_desc' value='<%= desc %>' />
									// <input type='hidden' name='(session)(session_<%= session_num %>)session_type' value='<%= type %>' />
									// <span class="session-desc"><%= desc %></span>
									// <span class="session-speaker"><%= speaker %></span>
									// <span class ="session-type"><%= type %></span>
									// <a href="#" class="add-subsession">+</a>
									<div class="control-group">
									    <label class="control-label" for="sessionDesc">Description:</label>
									    <div class="controls">
									        <input type="text" name="sessionDesc" id="sessionDesc" placeholder="">
									    </div>
									</div>
									<div class="control-group">
									    <label class="control-label" for="sessionSpeaker">Speaker:</label>
									    <div class="controls">
									        <input type="text" name="sessionSpeaker" class="typeahead" id="sessionSpeaker">
									    </div>
									</div>									

								</div>
							</script>
						</div>
					</form>
					
			    </div>
			    <!-- Fourth tab -->
			    <div class="tab-pane" id="tab-retreat">
			      <p>I'm in Section 4.</p>
			    </div>
			    <!-- Fifth tab -->
			    <div class="tab-pane" id="tab-orientation">
			      <p>I'm in Section 5.</p>
			    </div>

			  </div>
			</div>
			
		</div>
	</div>
</div>