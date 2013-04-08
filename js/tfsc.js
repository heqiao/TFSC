$(document).ready(function () {
	// datepicker
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	var typeahead_source = ['Aaaa', 'Abbb', 'Accc'];
	$('.typeahead').typeahead({
		source: typeahead_source
	});
//view to add the sessions
	var speaker_num = 1;
	var session_num = 1;
	var SectionView = Backbone.View.extend({

		tagName: "div",
		className: 'event-session alert alert-info',
		template: _.template($('#session-template-symp').html()), 
		events: {
			
			"click .new-speaker": "addSpeaker"
		},
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
		},
		
		addSpeaker: function() {
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
		}
	});

	var FormView = Backbone.View.extend({
		// HTML
		el: $('#main-form-symposium'), 

		// Event
		events: {
			"click #new-session": "newSession"
		},
		newSession: function () {
			console.log("newSession");
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
		}
	});

	var form_view = new FormView();
	console.log(form_view.events);

});
