// 
// $(document).ready(function(){
//     //Display the date picker
//     $( "#datepicker" ).datepicker();
// 
//     //
//     // $('#selectType').on('change', function(event){
//     //               var eventType = $(this).val();
//     //               console.log(eventType);
//     //               //Add sessions for a certain type of event
//     //               addSessions(eventType);
//     //             });
//     
//     function addSessions(eventType){
//         switch(eventType){
//             case 'select':
//                 $('#sessionId').remove();
//                 break;
//             case 'TA':
//                 $('#sessionId').remove();
//                 break;
//             case 'FACULTY':
//                 $('#sessionId').remove();
//                 break;
//             case 'SYMPOSIUM':
//                 //Clean the div
//                 $('#sessionId').remove();
//                 //Add sessions
//                 $('#selectType').after('<div id = "sessionId">'
//                     //+'<label>Session Name: </label> <input type = "text" name = "sessionName"> <br>'
//                     +'<label>Description: </label> <input type = "text" name = "sessionDesc" id = "sessionDesc"> <br>'
//                     +'<label>Speaker: </label> <input type = "text" name = "speaker" id = "sessionSpeaker"> <br>'
//                     +'<button class="btn" id = "sessionSubmit" type="button">Add Session</button>'
//                     +'</div>').show('slow');
//                 $('#sessionSubmit').click(function(){
//                     var desc = $.trim($('#sessionDesc').val());
//                     var speaker = $.trim($('#sessionSpeaker').val());
//                     var descLength = $.trim($('#sessionDesc').val()).length;
//                     if (descLength == 0) {
//                         $('#sessionId').append('<p style="display:inline"> Session description cannot be empty.</p>');
//                     }
//                     else{
//                             $('#sessionId').hide();
//                             $('#selectType').after('<div id = "newdiv">'
//                                 + 'Session: '
//                                 + desc
//                                 + ' With '
//                                 + speaker
//                                 + '<br>'
//                                 +'</div>');
//                             $('#selectType').after('<button class="btn" id = "anotherSession" type="button">Add Session</button>');
//                         $('#anotherSession').click(function(){
//                             $('#sessionId').show();
//                             $('#anotherSession').hide();
//                         });    
//                         };
// 
//                     
//                     }); 
//                 break;
//             case 'RETREAT':
//                 $('#sessionId').remove();
//                 break;
//         }
//     };
//     
// });

$(document).ready(function() {
    // datepicker
    $( "#datepicker" ).datepicker();
    
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
        template: _.template($('#session-template').html()),
        events: {
            "click .add-subsession": "addSubSession"
        },
        initialize: function() {
            console.log(this.options);
            this.$el.html(this.template(this.options));
        },
        addSubSession: function() {
            alert("aaa");
        }
    });
    
    var FormView = Backbone.View.extend({
        
        // HTML
        el: $('#main-form'),
        
        // Event
        events: {
            "change #selectType": "selectType",
            "click #add-session": "addSection"
        },
        
        selectType: function() {
            if ($('#selectType').val() == "SYMPOSIUM") 
            {
                $('.event-section').slideDown();
            }
            else
            {
                $('.event-section').slideUp();
            };
        },
        
        addSection: function() {
            var sectionView = new SectionView({
                desc: $('#sessionDesc').val(),
                speaker: $('#sessionSpeaker').val()
            });
            
            $('.event-section').after(sectionView.el);
        }
        
    });
    
    var form_view = new FormView();
    
});

                 
               