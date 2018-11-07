/**
* Class MainAgendaOrdenesView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAgendaOrdenesView = Backbone.View.extend({

        el: '#agendaordenes-main',
        template: _.template( ($('#add-info-event-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize : function() {
            // Reference to fields
            this.spinnerCalendar = this.$('#spinner-calendar');
            this.$calendar = this.$('#calendar');
            this.$modal = $('#modal-event-component');

            this.referenceCalendar();
        },

        referenceCalendar: function (){
            var _this = this;

            this.$calendar.fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventSources: [{
                    url: window.Misc.urlFull( Route.route('agendaordenes.index') ),
                    type: 'GET',
                    cache: true,
                    color: 'green',
                    textColor: 'white'
                }],
                eventLimit: true,
                eventClick: function(calEvent, jsEvent, view) {
                    _this.$modal.find('.content-modal').html( _this.template( calEvent ) );
                    _this.$modal.find('.modal-title').text( calEvent.title.trim() );
                    _this.$modal.modal('show');
                }
            });
        }
    });

})(jQuery, this, this.document);
