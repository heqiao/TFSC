
$(document).ready(function(){
	//Display the date picker
	$( "#datepicker" ).datepicker();
	//
	$('#selectType').on('change', function(event){
              var eventType = $(this).val();
              console.log(eventType);
              //Add sessions for a certain type of event
              addSessions(eventType);
            });
	
	function addSessions(eventType){
		switch(eventType){
			case 'select':
			$('#sessionId').remove();
			break;
			case 'TA':
			$('#sessionId').remove();

			break;
			case 'FACULTY':
			$('#sessionId').remove();
			break;
			case 'SYMPOSIUM':
			//Clean the div
			$('#sessionId').remove();
			//Add sessions
			$('#selectType').after('<div id = "sessionId">'
				+'<label>Session Name: </label> <input type = "text" name = "sessionName"> <br>'
				+'<label>Description: </label> <input type = "text" name = "sessionDesc"> <br>'
				+'<label>Speaker: </label> <input type = "text" name = "speaker"> <br>'
				+'<button class="btn" type="submit">Add Session</button>'
				
				+'</div>').show('slow');


			break;
			case 'RETREAT':
			$('#sessionId').remove();
			break;
		}
	};
});
                 
               