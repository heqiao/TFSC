<?php
include("_parts/functions.php");
 include("_parts/connection.php");

// HTML parts
include("_parts/html_head.php");
include("_parts/header.php");
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