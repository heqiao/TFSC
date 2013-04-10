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
	var breakout_num = 1;
	var speaker_num = 1;
	var session_num = 1;
	var SympSessionView = Backbone.View.extend({

		tagName: "div",
		className: 'event-session alert alert-info',
		template: _.template($('#session-template-symp').html()), 
		events: {
			"click .new-speaker": "addSpeaker"
		},
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
			var foo = $('.session-speaker');
			console.log(foo.size());

			 if(foo.size() == 0)
			 {
				this.$('.new-speaker').trigger('click');	
				speaker_num++;
			};
		},
		addSpeaker: function() {
			var session_num = this.options.session_num;
			//var speaker_num = this.options.speaker_num;
			var speakerView = new SpeakerView({
				session_num: session_num,
				speaker_num: speaker_num
			});
			this.$('.add-speaker').before(speakerView.el);
			//$('.sessionSpeaker').focus();
			speaker_num ++;

		}
	});
//view to add breakout session
	var BreakoutView = Backbone.View.extend({
		tagName: "div",
		className: 'breakout-session alert alert-info',
		template: _.template($('#breakout-template-symp').html()), 
		events: {
			"click .new-subsession": "newSubSession"
		},
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
		},
		newSubSession: function () {
			//console.log("newSubSession");
			var subSessionView = new SympSessionView({
				session_num: session_num,
				speaker_num: speaker_num
				// type: $('#sessionType option:selected').text(),
				// desc: $('#sessionDesc').val(),
				// speaker: $('#sessionSpeaker').val(),
				//desc: null,
				//speaker: null
			});
			$('.add-subsession').before(subSessionView.el);

			session_num ++;
			//console.log("end of newSubSession");
		}
	});
//view of speakers
	var SpeakerView = Backbone.View.extend({

		tagName: "div",
		className: 'session-speaker',
		template: _.template($('#speaker-template-symp').html()), 
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
		}
	});

	var SymposiumFormView = Backbone.View.extend({
		// HTML
		el: $('#main-form-symposium'), 

		// Event
		events: {
			"click #new-session": "newSession",
			"click #new-breakout": "newBreakout"
		},
		newBreakout: function(){
			var breakoutView = new BreakoutView({
				breakout_num:breakout_num,
				session_num: session_num,
				speaker_num: speaker_num
			});
			$('.event-section').before(breakoutView.el);

			breakout_num ++;
			// console.log("end of newBreakout");
		},
		newSession: function () {
			var sessionView = new SympSessionView({
				session_num: session_num,
				speaker_num: speaker_num
				// type: $('#sessionType option:selected').text(),
				// desc: $('#sessionDesc').val(),
				// speaker: $('#sessionSpeaker').val(),
				//desc: null,
				//speaker: null
			});
			$('.event-section').before(sessionView.el);
			$('.sessionDesc').focus();
			session_num ++;
		}
	});

	var symposium_form_view = new SymposiumFormView();
	console.log(symposium_form_view.events);

});
