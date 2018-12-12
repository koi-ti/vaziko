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
                        element.css('background-color', 'gray');
                        element.css('border-color', 'white');

                    }else if( parseInt(event.orden_abierta) ){

                        if (event.orden_fecha_entrega+' '+event.orden_hora_entrega < moment().format('YYYY-MM-DD H:m:s')) {
                            element.addClass('fc-draggable');
                            element.css('background-color', '#DD4B39');
                            element.css('border-color', 'white');

                        } else {
                            element.addClass('fc-draggable');
                            element.css('background-color', '#00A65A');
                            element.css('border-color', 'white');

                        }

                    } else {
                        element.addClass('fc-draggable');
                        element.css('background-color', 'black');
                        element.css('border-color', 'white');

                    }

                    if( event.type == 'R1' || event.type == 'R2') {
                        element.addClass('fc-draggable');
                        element.css('background-color', '#337AB7');
                        element.css('border-color', 'white');

                    }
                },
            });
        }
    });

})(jQuery, this, this.document);
