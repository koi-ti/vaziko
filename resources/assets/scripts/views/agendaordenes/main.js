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
                    _this.$modal.find('.modal-title').text( 'Orden de producción # ' + calEvent.title.trim() );
                    _this.$modal.modal('show');
                },
                eventAfterRender: function(event, element, view) {
                    if ( parseInt(event.orden_culminada ) ){
                        element.addClass('fc-draggable');
                        element.css('background-color', '#00C0EF');
                        element.css('border-color', '#00C0EF');

                    }else if( parseInt(event.orden_anulada ) ){
                        element.addClass('fc-draggable');
                        element.css('background-color', '#DD4B39');
                        element.css('border-color', '#DD4B39');

                    }else if( parseInt(event.orden_abierta) ){
                        element.addClass('fc-draggable');
                        element.css('background-color', '#00A65A');
                        element.css('border-color', '#00A65A');

                    } else {
                        element.addClass('fc-draggable');
                        element.css('background-color', '#F39C12');
                        element.css('border-color', '#F39C12');

                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
