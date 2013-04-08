$(document).ready(function () {
	// datepicker
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	var typeahead_source = ['Aaaa', 'Abbb', 'Accc'];
	$('.typeahead').typeahead({
		source: typeahead_source
	});
	// $('#selectType').on('change', function(event) {
	//     if ($(this).val() == "SYMPOSIUM") 
	//     {
	//         $('.event-section').slideDown();
	//     };
	// });
	// 
	// var temp = _.template( $('#session-template').html() );
	// $('#add-session').on('click', function(event) {
	//     var html = temp({ 
	//         desc: $('#sessionDesc').val(), 
	//         speaker: $('#sessionSpeaker').val() 
	//     });
	//     $('.event-section').after(html);
	// });
//view to add the sessions
	var speaker_num = 1;
	var SectionView = Backbone.View.extend({

		tagName: "div",
		className: 'event-session',
		template: _.template($('#session-template-symp').html()), 
		events: {
			"click .add-subsession": "addSubSession",
			"click .new-speaker": "addSpeaker"
		},
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
		},
		addSubSession: function () {
			$('.event-section').slideUp();
		},
		addSpeaker: function() {
			console.log("add speaker");
			var session_num = this.options.session_num;
			var speakerView = new SpeakerView({
				session_num: session_num,
				speaker_num: speaker_num
			});

			this.$('.add-speaker').after(speakerView.el);
			speaker_num ++;
		}
	});
//view to add speakers
	var SpeakerView = Backbone.View.extend({

		tagName: "div",
		className: 'session-speaker',

		template: _.template($('#speaker-template-symp').html()), 
		events: {
			"click .add-subsession": "addSubSession"
		},
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
		},
		addSubSession: function () {
			$('.event-section').slideUp();
		}
	});

	var session_num = 1;
	

	var FormView = Backbone.View.extend({

		// HTML
		el: $('#main-form-symposium'), 

		// Event
		events: {
			"click #new-session": "newSession",
			
			"change #selectType": "selectType",
			"click #add-session": "addSection",
			"change #break-num": "breakNum",
			"click #create-speaker": "createSpeaker"
		},
		newSession: function () {
			console.log("newSession");
			 //var session_num = 1;
			var sectionView = new SectionView({
				session_num: session_num
				// type: $('#sessionType option:selected').text(),
				// desc: $('#sessionDesc').val(),
				// speaker: $('#sessionSpeaker').val(),
				//desc: null,
				//speaker: null
			});
			$('.event-section').after(sectionView.el);
			session_num ++;
			console.log("end of newSession");
		},

		newSpeaker: function(){
			console.log("new speaker");
			
			
			

		},

		breakNum: function () {
			var breakVal = $("#break-num").val();

			if(breakVal == 1) {
				$('#sessionType').html('<option value="1">Individual</option> <option value="2">Breakout Session 1</option>');
			} else if(breakVal == 2) {
				$('#sessionType').html('<option value="1">Individual</option>' + '<option value="2">Breakout Session 1</option>' + '<option value="3">Breakout Session 2</option>');
			} else if(breakVal == 3) {
				$('#sessionType').html('<option value="1">Individual</option>' + '<option value="2">Breakout Session 1</option>' + '<option value="3">Breakout Session 2</option>' + '<option value="4">Breakout Session 3</option>');
			} else if(breakVal == 4) {
				$('#sessionType').html('<option value="1">Individual</option>' + '<option value="2">Breakout Session 1</option>' + '<option value="3">Breakout Session 2</option>' + '<option value="4">Breakout Session 3</option>' + '<option value="5">Breakout Session 4</option>');
			};

			//$('.event-section').slideUp();
			$('.event-session').slideUp();
			$('.speaker-section').slideUp();
		},
		selectType: function () {
			if($('#selectType').val() == "SYMPOSIUM") {

				$('.break-section').slideDown();
				$('.event-section').slideDown();

			} else {
				$('.break-section').slideUp();
				$('.event-section').slideUp();
				$('.event-session').slideUp();
				$('.speaker-section').slideUp();
			};
		},

		//  addSection: function() {
		//      var sectionView = new SectionView({
		//          desc: $('#sessionDesc').val(),
		//          speaker: $('#sessionSpeaker').val(),
		//          session_num: session_num,
		//          type: $('#sessionType option:selected').text()
		//      });


		//      $('.event-section').after(sectionView.el);
		//       session_num++;            
		// },
		createSpeaker: function () {
			$('.speaker-section').slideDown();
		}

	});

	var form_view = new FormView();
	console.log(form_view.events);

});
