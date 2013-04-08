
<!-- event name -->
<div class="control-group">
	<label class="control-label" for="eventName<?php echo $event_type;?>">Event Name:</label>
	<div class="controls">
		<input type="text" name = "name" id="eventName<?php echo $event_type;?>"  placeholder="" required>
	</div>
</div>
<!-- date -->
<div class="control-group">
	<label class="control-label" for="datepicker<?php echo $event_type;?>">Date:</label>
	<div class="controls">
		<input type="text" name = "date" id="datepicker<?php echo $event_type;?>" class = "datepicker" placeholder="">
	</div>
</div>
<!-- location -->
<div class="control-group">
	<label class="control-label" for="eventLoc<?php echo $event_type;?>">Location:</label>
	<div class="controls">
		<input type="text" name = "location" id="eventLoc<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- desc -->
<div class="control-group">
	<label class="control-label" for="Description<?php echo $event_type;?>">Description:</label>
	<div class="controls">
		<textarea name="description" id = "eventDesc<?php echo $event_type;?>" rows="3"></textarea>
	</div>
</div>
<!-- start time -->
<div class="control-group">
	<label class="control-label" for="eventStart<?php echo $event_type;?>">Start Time:</label>
	<div class="controls">
		<input type="text" name = "start_time" id="eventStart<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- end time -->
<div class="control-group">
	<label class="control-label" for="eventEnd<?php echo $event_type;?>">End Time:</label>
	<div class="controls">
		<input type="text" name = "end_time" id="eventEnd<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- contact name -->
<div class="control-group">
	<label class="control-label" for="eventContactName<?php echo $event_type;?>">Contact Name:</label>
	<div class="controls">
		<input type="text" name = "contact_name" id="eventContactName<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- contact email -->
<div class="control-group">
	<label class="control-label" for="eventContactEmail<?php echo $event_type;?>">Contact Email:</label>
	<div class="controls">
		<input type="text" name = "contact_email" id="eventContactEmail<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- contact phone -->
<div class="control-group">
	<label class="control-label" for="eventContactPhone<?php echo $event_type;?>">Contact Phone:</label>
	<div class="controls">
		<input type="text" name = "contact_phone" id="eventContactPhone<?php echo $event_type;?>" placeholder="">
	</div>
</div>
<!-- sumbit form -->
<div class="control-group">
	<div class="controls">
		<button class="btn" type="submit" name ="submitEvent<?php echo $event_type;?>">Add Event</button>
	</div>
</div>