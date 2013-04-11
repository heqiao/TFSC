<?php
require_once "_parts/functions.php";
require_once "_parts/db_settings.php";

// HTML parts
$page_stylesheet = "create_event.css";
// $page_javascript = "";
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
		$session_order = 1;
		foreach ($post['session'] as $key => $session) {
			$new_session = new Session(array(
				'title' => $session['sessionDesc'],
				'group_name' => $session['groupName'],
				'order' => $session_order
			));
			$event->add_session($new_session);
			$session_order ++;
			foreach ($session['speaker'] as $key => $speaker) {
				$new_speaker = new Speaker(array(
					"first_name" => $speaker['sessionSpeaker'],
					"last_name" => $speaker['sessionSpeaker'],
					"prefix" => $speaker['sessionSpeaker'],
					"title" => $speaker['sessionSpeaker'],
					"department" => $speaker['sessionSpeaker'],
					"organization" => $speaker['sessionSpeaker']
				));
				$new_session->add_speaker($new_speaker);
			}
		}
	}
	//The retreat form is submitted		  
	if(isset($_POST['submitEvent-retreat'])){         
		$post = PostParse($_POST);
		$event = new Event(array(
		 	"name" => $post['eventName'],
			"date" => $post['datepicker'], 
			"location" => $post['eventLoc'], 
			"event_type"=> "Retreat", 
			"description" => $post['Description'], 
			"start_time" => $post['eventStart'],
			"end_time" => $post['eventEnd'],
			"contact_name" => $post['eventContactName'],
			"contact_email" => $post['eventContactEmail'],
			"contact_phone" => $post['eventContactPhone']
		));
		$event->save();
		foreach ($post['session'] as $key => $session) {
			$new_session = new Session(array(
				'title' => $session['sessionTitle'],
				'group_name' => $session['sessionGroup']
			));
			$event->add_session($new_session);
		}
	}
	//The orientation form is submitted		  
	if(isset($_POST['submitEvent-orient'])){         
		$post = PostParse($_POST);
		$event = new Event(array(
		 	"name" => $post['eventName'],
			"date" => $post['datepicker'], 
			"location" => $post['eventLoc'], 
			"event_type"=> "Orientation", 
			"description" => $post['Description'], 
			"start_time" => $post['eventStart'],
			"end_time" => $post['eventEnd'],
			"contact_name" => $post['eventContactName'],
			"contact_email" => $post['eventContactEmail'],
			"contact_phone" => $post['eventContactPhone']
		));
		$event->save();
		foreach ($post['session'] as $key => $session) {
			$new_session = new Session(array(
				'title' => $session['sessionTitle'],
				'group_name' => $session['sessionPart']
				
			));
			$event->add_session($new_session);
		}
	}		    	
?>

<div class="container">
	<div class="row">
		
		<!-- sidebar -->
		<div class="span3">
			<?php include("_parts/sidebar.php"); ?>
		</div>
		
		<!-- form -->
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
									<div class="symp-session-section">
					
									</div>
								</div>
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
									<div class="add-session-control">
										<button class="btn" id="new-session-retreat" type="button">Add Session</button>
										<!-- <button class="btn" id="new-breakout" type="button">Add Breakout Session</button> -->
									</div>
									<div class = "retreat-session-section">

									</div>
								</div>
							</div>
						</form>			
				    </div>
				    <!-- Fifth tab Orientation-->
				    <div class="tab-pane" id="tab-orientation">
				      <form id="main-form-orient" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div class ="row-fluid">
								<!-- Left part of the form -->
								<div class ="span6">
									<?php 
										$event_type = "-orient";
										include("_parts/event_form.php"); ?>
								</div>
								<!-- Right part of the form -->
								<div class = "span6">
									<div class="add-session-control">
										<button class="btn" id="new-session-orient" type="button">Add Session</button>
										<!-- <button class="btn" id="new-breakout" type="button">Add Breakout Session</button> -->
									</div>
									<div class = "orient-session-section">
									</div>
								</div>
							</div>
						</form>	
				    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- Template for add a new session for orientation-->
	<script type="text/template" id="session-template-orient" charset="utf-8">
		<div class="control-group">
			<input type="text" name="(session)(session_<%= session_num %>)sessionTitle" class="sessionDesc" placeholder="Title">
		</div>
		<div class="control-group">
			<select name = "sessionPart">
		  		<option>Morning Session</option>
		  		<option>Afternoon Session</option>
			</select>
		</div>									
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</script>
	<!-- Template for add a new session for retreat-->
	<script type="text/template" id="session-template-retreat" charset="utf-8">
		<div class="control-group">
			<input type="text" name="(session)(session_<%= session_num %>)sessionGroup" class="sessionDesc" placeholder="Group">
			<input type="text" name="(session)(session_<%= session_num %>)sessionTitle" class="sessionDesc" placeholder="Title">
		</div>									
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</script>
	<!-- Template for add a new session for symposium-->
	<script type="text/template" id="session-template-symp" charset="utf-8">
		<div class="control-group">
			<input type="text" name="(session)(session_<%= session_num %>)sessionDesc" class="sessionDesc" placeholder="Description">
			<% if (typeof(group_name) !== 'undefined') { %>
      		<input type="hidden" name="(session)(session_<%= session_num %>)groupName" class="sessionDesc" value="<%= group_name %>" >
    		<% } %>
		</div>
		<div class="control-group">
		    <div class="add-speaker">
			</div>
		    <button class="btn new-speaker" type="button">Add Speaker</button>
		</div>									
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</script>
	<!-- Template for adding a breakout session for sumposium
	-->
	<script type="text/template" id="breakout-template-symp" charset="utf-8">
		<h3>Breakout Session <%= breakout_num %></h3>
		<input type='hidden' class="breakout-session-view-group-name" value='Breakout Session <%= breakout_num %>' />
		<div class="addSub">
				
		</div>
		<button class="btn new-subsession" type="button">Add subSession</button>								
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</script>	
	<!-- Template for adding a speaker -->
	<script type="text/template" id="speaker-template-symp" charset="utf-8">
		<input type="text" name="(session)(session_<%= session_num %>)(speaker)(speaker_<%= speaker_num %>)sessionSpeaker" 
		class="sessionSpeaker" placeholder="Speaker">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</script>
</div>
