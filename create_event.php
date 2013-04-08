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

	//The TA form is submitted
	if(isset($_POST['submitEvent-ta'])){			
		$post = PostParse($_POST);
		$event = new Event(array(
		 	"name" => $post['eventName'],
			"date" => $post['datepicker'], 
			"location" => $post['eventLoc'], 
			"event_type"=> "TA luncheon", 
			"description" => $post['Description'], 
			"start_time" => $post['eventStart'],
			"end_time" => $post['eventEnd'],
			"contact_name" => $post['eventContactName'],
			"contact_email" => $post['eventContactEmail'],
			"contact_phone" => $post['eventContactPhone']
		));
		$event->save();	
	}
	//The luncheon form is submitted
	if(isset($_POST['submitEvent-luncheon'])){
		$post = PostParse($_POST);
		$event = new Event(array(
		 	"name" => $post['eventName'],
			"date" => $post['datepicker'], 
			"location" => $post['eventLoc'], 
			"event_type"=> "Luncheon", 
			"description" => $post['Description'], 
			"start_time" => $post['eventStart'],
			"end_time" => $post['eventEnd'],
			"contact_name" => $post['eventContactName'],
			"contact_email" => $post['eventContactEmail'],
			"contact_phone" => $post['eventContactPhone']
		));
		$event->save();	
	}
	//The symposium form is submitted		  
	if(isset($_POST['submitEvent-symp'])){         
		$post = PostParse($_POST);
		echo '<pre>';
			print_r($post);
			echo '</pre>';
		$event = new Event(array(
		 	"name" => $post['eventName'],
			"date" => $post['datepicker'], 
			"location" => $post['eventLoc'], 
			"event_type"=> "Symposium", 
			"description" => $post['Description'], 
			"start_time" => $post['eventStart'],
			"end_time" => $post['eventEnd'],
			"contact_name" => $post['eventContactName'],
			"contact_email" => $post['eventContactEmail'],
			"contact_phone" => $post['eventContactPhone']
		));
		$event->save();
		foreach ($post['session'] as $key => $session) {
			echo '<pre>';
			print_r($session);
			echo '</pre>';
			$new_session = new Session(array(
				'title' => $session['sessionDesc']
			));
			$event->add_session($new_session);	
		}
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
			    	
			    	<form id="main-form-ta" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php 
							$event_type = "-ta"; //Define distingush id in the form
							include("_parts/event_form.php"); 
						?> 
					</form>	    	 
			    </div>
			    <!-- Second tab luncheon-->
			    <div class="tab-pane" id="tab-luncheon">
			     	<form id="main-form-luncheon" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<?php 
							$event_type = "-luncheon";
							include("_parts/event_form.php"); 
						?> 
					</form>
			    </div>
			    <!-- Third tab Symposium-->
			    <div class="tab-pane" id="tab-symposium">
			    	
			    	<form id="main-form-symposium" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class ="row-fluid">
							<!-- Left part of the form -->
							<div class ="span6">
								<?php 
									$event_type = "-symp";
									include("_parts/event_form.php");
								 ?>
							</div>
							<!-- Right part of the form -->
							<div class = "span6">
								<div class="add-session-control">
									<button class="btn" id="new-session" type="button">Add Session</button>
									<button class="btn" id="new-breakout" type="button">Add Breakout Session</button>
								</div>
								<div class="event-section">
				
								</div>
								<div class ="breakout-section">
								</div>
							</div>
							
							<!-- <input type='hidden' name='(session)(session_<%= session_num %>)sessionOrder' value='<%= session_num %>' /> -->
							<!-- <div class="controls">
							<input type="text" name="(session)(session_<%= session_num %>)(speaker_<%= speaker_num %>)sessionSpeaker" class="typeahead" id="sessionSpeaker" placeholder="Speaker">
							</div> 
							<input type="text" name="(session)(session_<%= session_num %>)(speaker)(speaker_<%= speaker_num %>)sessionSpeaker" 
									class="typeahead" id="sessionSpeaker" placeholder="Speaker"> 
							-->
							<!-- Template for add a new session -->
							<script type="text/template" id="session-template-symp" charset="utf-8">
								<div class="control-group">
									<input type="text" name="(session)(session_<%= session_num %>)sessionDesc" id="sessionDesc" placeholder="Description">
										
								</div>
								<div class="control-group">
								    <div class="add-speaker">
									</div>
								    	<button class="btn new-speaker" type="button">Add Speaker</button>
								</div>									
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								
							</script>
							<!-- Template for adding a breakout session -->
							<script type="text/template" id="breakout-template-symp" charset="utf-8">
								<h3>Breakout Session <%= breakout_num %></h3>
								<button class="btn" class="new-subsession" type="button">Add subSession</button>
								<div class="control-group">
									<input type="text" name="(session)(session_<%= session_num %>)sessionDesc" id="sessionDesc" placeholder="Description">
									<input type="text" name="(session)(session_<%= session_num %>)(speaker)(speaker_<%= speaker_num %>)sessionSpeaker" 
									class="typeahead" id="sessionSpeaker" placeholder="Speaker"> 	
								</div>
								<div class="control-group">
								    <div class="add-speaker">
									</div>
								    	<button class="btn new-speaker" type="button">Add Speaker</button>
								</div>									
								<button type="button" class="close" data-dismiss="alert">&times;</button>
									<div class="add-subsession">
									</div>
							</script>	
							<!-- Template for adding a speaker -->
							<script type="text/template" id="speaker-template-symp" charset="utf-8">
								<input type="text" name="(session)(session_<%= session_num %>)(speaker)(speaker_<%= speaker_num %>)sessionSpeaker" 
								class="typeahead" id="sessionSpeaker" placeholder="Speaker">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
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