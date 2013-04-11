<!-- Template for add a new session for symposium-->
<script type="text/template" id="session-template-orient" charset="utf-8">
	<div class="control-group">
		<input type="text" name="(session)(session_<%= session_num %>)sessionTitle" class="sessionDesc" placeholder="Title">
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
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<div class="control-group">
		<input type="text" name="(session)(session_<%= session_num %>)sessionDesc" class="sessionDesc" placeholder="Description">
		<% if (typeof(group_name) !== 'undefined') { %>
			<input type="hidden" name="(session)(session_<%= session_num %>)groupName" class="sessionDesc" value="<%= group_name %>" >
		<% } %>
	</div>
	<div class="control-group">
	    <div class="add-speaker alert alert-success"></div>
	    <button class="btn new-speaker" type="button">Add Speaker</button>
	</div>
</script>
<!-- Template for adding a breakout session for sumposium-->
<script type="text/template" id="breakout-template-symp" charset="utf-8">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h3>Breakout Session <%= breakout_num %></h3>
	<input type='hidden' class="breakout-session-view-group-name" value='Breakout Session <%= breakout_num %>' />
	<div class="addSub"></div>
	<button class="btn new-subsession" type="button">Add subSession</button>
</script>	
<!-- Template for adding a speaker -->
<script type="text/template" id="speaker-template-symp" charset="utf-8">
	<button type="button" class="close speaker" data-dismiss="alert">&times;</button>
	<input type="text" name="(session)(session_<%= session_num %>)(speaker)(speaker_<%= speaker_num %>)sessionSpeaker" class="typeahead sessionSpeaker" placeholder="Speaker">
</script>
