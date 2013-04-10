$(document).ready(function () {
	// datepicker
	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	var typeahead_source = ['Aaaa', 'Abbb', 'Accc'];
	$(".typeahead").typeahead({
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
			this.$el.html(this.template(this.options));
			// if there is no speaker, add one 
			var speaker_sec_num = this.$('.session-speaker');			
			if(speaker_sec_num.size() == 0)
			{
				this.addSpeaker();
				//speaker_num++;
			};
		},
		addSpeaker: function() {
			var session_num = this.options.session_num;
			//var speaker_num = this.options.speaker_num;
			var speakerView = new SpeakerView({
				session_num: session_num,
				speaker_num: speaker_num
			});
			this.$('.add-speaker').append(speakerView.el);
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
			this.$el.html(this.template(this.options));
			var session_sec_num = this.$('.event-session alert alert-info');
			//console.log(session_sec_num);	
			// alert(session_sec_num.size());		
			if(session_sec_num.size() == 0)
			{
				this.newSubSession();
				//session_num++;
			};
		},
		newSubSession: function () {
			var subSessionView = new SympSessionView({
				session_num: session_num,
				speaker_num: speaker_num
			});
			this.$('.addSub').before(subSessionView.el);
			session_num ++;
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
//Symposium form view
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
				breakout_num:breakout_num
			});
			$('.symp-session-section').before(breakoutView.el);
			breakout_num ++;
		},
		newSession: function () {
			var sessionView = new SympSessionView({
				session_num: session_num,
				speaker_num: speaker_num
			});
			$('.symp-session-section').before(sessionView.el);
			$('.sessionDesc').focus();
			session_num ++;
		}
	});
	//Retreat session view
	var RetreatSessionView = Backbone.View.extend({

		tagName: "div",
		className: 'retreat-session alert alert-info',
		template: _.template($('#session-template-retreat').html()), 
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
			}
		});
	// Retreat form view
	var RetreatFormView	= Backbone.View.extend({
		// HTML
		el: $('#main-form-retreat'),

		// Event
		events:{
			"click #new-session-retreat":"newRetreatSession"
		},
		newRetreatSession: function(){
			var retreatSessionView = new RetreatSessionView({
				session_num:session_num
			}); 
			$('.retreat-session-section').before(retreatSessionView.el);
			session_num ++;
		}
	});
	//Orient session view
	var OrientSessionView = Backbone.View.extend({

		tagName: "div",
		className: 'orient-session alert alert-info',
		template: _.template($('#session-template-orient').html()), 
		initialize: function () {
			// console.log(this.options);
			this.$el.html(this.template(this.options));
			}
		});
	// Orient form view
	var OrientFormView	= Backbone.View.extend({
		// HTML
		el: $('#main-form-orient'),

		// Event
		events:{
			"click #new-session-orient":"newOrientSession"
		},
		newOrientSession: function(){
			var orientSessionView = new OrientSessionView({
				session_num:session_num
			}); 
			$('.orient-session-section').before(orientSessionView.el);
			session_num ++;
		}
	});
	var symposium_form_view = new SymposiumFormView();
	var retreat_form_view = new RetreatFormView();
	var orient_form_view = new OrientFormView();
	//console.log(orient_form_view.events);

});
