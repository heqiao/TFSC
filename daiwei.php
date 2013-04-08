<?php
require_once "_parts/functions.php";
require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>

<?php
	// $connection = mysql_connect("localhost","root", "");
	// 		//Run the connection string to connecct to the databse
	// mysql_select_db("tfscdb") or die("Cannot open the database");
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
			    	
			    	<form id="main-form-ta" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php 
							$event_type = "-ta"; //Define distingush id in the form
							include("_parts/event_form.php"); 
						?> 
					</form>
					<?php
			    		if(isset($_POST['submitEvent-ta'])){
							// $eventType = "TA Luncheon";
							// $event = new Event($_POST);	
						}
			    	?>	    	 
			    </div>
			    <!-- Second tab luncheon-->
			    <div class="tab-pane" id="tab-luncheon">
			    	<?php
			    		if(isset($_POST['submitEvent-luncheon'])){
							// $eventType = "Faculty Luncheon";
							// $event = new Event($_POST);	
						}
					?>
			     	<form id="main-form-luncheon" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php 
							$event_type = "-luncheon";
							include("_parts/event_form.php"); 
						?> 
					</form>
			    </div>
			    <!-- Third tab Symposium-->
			    <div class="tab-pane" id="tab-symposium">
			    	<?php

			    		if(isset($_POST['submitEvent-symp']))
						{
							// $eventType = "symposium";
							 $event = new Event(array(
							 	"name" => $_POST['name'],
								"date" => $_POST['date'], 
								"location" => $_POST['location'], 
								"event_type"=> $_POST['event_type'], 
								"description" => $_POST['description'], 
								"start_time" => $_POST['start_time'],
								"end_time" => $_POST['end_time'],
								"contact_name" => $_POST['contact_name'],
								"contact_email" => $_POST['contact_email'],
								"contact_phone" => $_POST['contact_phone']
							 ));

							 $event->save();
							 
							 foreach ($sessions as $key => $session) {
								// echo '<pre>';
								// print_r($sessions);
								// echo '</pre>';

								//$sessionDesc  = strip_tags(trim($session["sessionDesc"]));
							}

							// $event->insertSession($event->event_attr['session']);
						}
			    	?>
			    	<form id="main-form-symposium" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class ="row-fluid">
							<!-- Left part of the form -->
							<div class ="span6">
								<?php 
									$event_type = "-symp";
									include("_parts/daiwei_form.php"); ?>
							</div>
							<!-- Right part of the form -->
							<div class = "span6">
								<div class="add-session-control">
									<button class="btn" id="new-session" type="button">Add Session</button>
									<button class="btn" id="new-breakout" type="button">Add Breakout Session</button>
								</div>
								<div class="event-section">
				
								</div>
								
							</div>
							
							<!-- // <input type='hidden' name='(session)(session_<%= session_num %>)sessionOrder' value='<%= session_num %>' /> -->
							<!-- // <div class="controls">
									    //     <input type="text" name="(session)(session_<%= session_num %>)(speaker_<%= speaker_num %>)sessionSpeaker" class="typeahead" id="sessionSpeaker" placeholder="Speaker">
									    // </div> -->
			
							<script type="text/template" id="session-template-symp" charset="utf-8">
								<div class="event-session">
									<div class="control-group">
									    <div class="controls">
									        <input type="text" name="(session)(session_<%= session_num %>)sessionDesc" id="sessionDesc" placeholder="Description">
									        
									    </div>

									</div>
									<div class="control-group">
									    
									    <div class="add-speaker">
				
										</div>
									    <div class = "controls">
									    	<button class="btn new-speaker" type="button">Add Speaker</button>
									    </div>
									</div>									
								</div>
							</script>

							<script type="text/template" id="speaker-template-symp" charset="utf-8">
								<div class = "session-speaker">
									<div class="controls">
									        <input type="text" name="(session)(session_<%= session_num %>)(speaker_<%= speaker_num %>)sessionSpeaker" class="typeahead" id="sessionSpeaker" placeholder="Speaker">
									</div>
								</div>
							</script>
						</div>
					</form>
					
			    </div>
			    <!-- Fourth tab Retreat-->
			    <div class="tab-pane" id="tab-retreat">
			    	<form id="main-form-retreat" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class ="row-fluid">
							<!-- Left part of the form -->
							<div class ="span6">
								<?php
									//distinguish different IDs in the form 
									$event_type = "-retreat";
									include("_parts/event_form.php"); 
								?>
							</div>
							<!-- Right part of the form -->
							<div class = "span6">
							</div>
						</div>
					</form>			
			    </div>
			    <!-- Fifth tab Orientation-->
			    <div class="tab-pane" id="tab-orientation">
			      <form id="main-form-orientation" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class ="row-fluid">
							<!-- Left part of the form -->
							<div class ="span6">
								<?php 
									$event_type = "-orientation";
									include("_parts/event_form.php"); ?>
							</div>
							<!-- Right part of the form -->
							<div class = "span6">
							</div>
						</div>
					</form>	
			    </div>

			  </div>
			</div>
			
		</div>
	</div>
</div>