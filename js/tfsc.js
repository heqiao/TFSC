// 
$(document).ready(function(){
    //Display the date picker
    $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
    //let the user choose the speaker
    var typeahead_source = ['Aaaa', 'Abbb', 'Accc'];
    $('.typeahead').typeahead({
        source: typeahead_source
    });
    
    //
    // $('#selectType').on('change', function(event){
    //               var eventType = $(this).val();
    //               console.log(eventType);
    //               //Add sessions for a certain type of event
    //               addSessions(eventType);
    //             });
    
    // function addSessions(eventType){
    //     switch(eventType){
    //         case 'select':
    //             $('#sessionId').remove();
    //             break;
    //         case 'TA':
    //             $('#sessionId').remove();
    //             break;
    //         case 'FACULTY':
    //             $('#sessionId').remove();
    //             break;
    //         case 'SYMPOSIUM':
    //             //Clean the div
    //             $('#sessionId').remove();
    //             //Add sessions
    //             $('#selectType').after('<div id = "sessionId">'
    //                 //+'<label>Session Name: </label> <input type = "text" name = "sessionName"> <br>'
    //                 +'<label>Description: </label> <input type = "text" name = "sessionDesc" id = "sessionDesc"> <br>'
    //                 +'<label>Speaker: </label> <input type = "text" name = "speaker" id = "sessionSpeaker"> <br>'
    //                 +'<button class="btn" id = "sessionSubmit" type="button">Add Session</button>'
    //                 +'</div>').show('slow');
    //             $('#sessionSubmit').click(function(){
    //                 var desc = $.trim($('#sessionDesc').val());
    //                 var speaker = $.trim($('#sessionSpeaker').val());
    //                 var descLength = $.trim($('#sessionDesc').val()).length;
    //                 if (descLength == 0) {
    //                     $('#sessionId').append('<p style="display:inline"> Session description cannot be empty.</p>');
    //                 }
    //                 else{
    //                         $('#sessionId').hide();
    //                         $('#selectType').after('<div id = "newdiv">'
    //                             + 'Session: '
    //                             + desc
    //                             + ' With '
    //                             + speaker
    //                             + '<br>'
    //                             +'</div>');
    //                         $('#selectType').after('<button class="btn" id = "anotherSession" type="button">Add Session</button>');
    //                     $('#anotherSession').click(function(){
    //                         $('#sessionId').show();
    //                         $('#anotherSession').hide();
    //                     });    
    //                     };

                    
    //                 }); 
    //             break;
    //         case 'RETREAT':
    //             $('#sessionId').remove();
    //             break;
    //     }
    // };
    
});

$(document).ready(function() {
    // datepicker
    $('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
    
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
    
    var SectionView = Backbone.View.extend({
        
        tagName: "div",
        className: 'event-session',
       
        template: _.template($('#session-template-symp').html()), //changed to symposiummmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm
        events: {
            "click .add-subsession": "addSubSession"
        },
        initialize: function() {
            // console.log(this.options);
            this.$el.html(this.template(this.options));
        },
        addSubSession: function() {
           $('.event-section').slideUp();
        }
    });

    // var session_num = 1;

    var FormView = Backbone.View.extend({
        
        // HTML
        el: $('#main-form-symposium'),//changed to sympsiummmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm
        
        // Event
        events: {
            "click #new-session": "newSession",
            "change #selectType": "selectType",
            "click #add-session": "addSection",
            "change #break-num" : "breakNum",
            "click #create-speaker":"createSpeaker"
        },
        newSession:function(){
            var sectionView = new SectionView({
                
                // session_num: session_num,
                // type: $('#sessionType option:selected').text(),
                // desc: $('#sessionDesc').val(),
                // speaker: $('#sessionSpeaker').val()
                // desc: null,
                // speaker: null
            });
            
             console.log("newsession");
            $('.event-section').after(sectionView.el);
        },

        breakNum: function(){
             var breakVal = $("#break-num").val();
            
            if (breakVal == 1) {
                $('#sessionType').html('<option value="1">Individual</option> <option value="2">Breakout Session 1</option>');
            }
            else if (breakVal == 2) {
                $('#sessionType').html('<option value="1">Individual</option>' 
                    +'<option value="2">Breakout Session 1</option>' 
                    +'<option value="3">Breakout Session 2</option>');
            }
            else if (breakVal == 3){
                 $('#sessionType').html('<option value="1">Individual</option>' 
                    +'<option value="2">Breakout Session 1</option>' 
                    +'<option value="3">Breakout Session 2</option>' 
                    +'<option value="4">Breakout Session 3</option>');
            }
            else if (breakVal == 4){
                 $('#sessionType').html('<option value="1">Individual</option>' 
                    +'<option value="2">Breakout Session 1</option>' 
                    +'<option value="3">Breakout Session 2</option>'
                    +'<option value="4">Breakout Session 3</option>'
                    +'<option value="5">Breakout Session 4</option>');
            };

             //$('.event-section').slideUp();
             $('.event-session').slideUp();
             $('.speaker-section').slideUp();
        },
        selectType: function() {
            if ($('#selectType').val() == "SYMPOSIUM") 
            {

                $('.break-section').slideDown();
                $('.event-section').slideDown();

            }
            else
            {
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
       createSpeaker:function(){
        $('.speaker-section').slideDown();
       }
        
    });
    
    var form_view = new FormView();
    console.log(form_view.events);
    
});

                 
               