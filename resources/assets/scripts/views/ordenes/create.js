/**
* Class CreateOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenpView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-ordenp-tpl').html() || '') ),
        events: {
            'click .submit-ordenp': 'submitOrdenp',
            'submit #form-ordenes': 'onStore',
            'ifChanged .change-recogida': 'changeRecogidas'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html( this.template(attributes) );
            this.$form = this.$('#form-ordenes');
            this.spinner = this.$('#spinner-main');

            // This ready
            this.ready();
        },

        /**
        * Event change checks
        */
        changeRecogidas: function (e) {
            var selected = $(e.target).is(':checked'),
                estado = $(e.target).data('change');

            if( selected ){
                (estado == 'R1') ? this.$('#orden_fecha_recogida1').removeAttr('disabled') : '';
                (estado == 'R2') ? this.$('#orden_fecha_recogida2').removeAttr('disabled') : '';
            }else{
                (estado == 'R1') ? this.$('#orden_fecha_recogida1').val('').attr('disabled', 'disabled') : '';
                (estado == 'R2') ? this.$('#orden_fecha_recogida2').val('').attr('disabled', 'disabled') : '';
            }
        },

        /**
        * Event submit productop
        */
        submitOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheckPicker == 'function' )
                window.initComponent.initICheckPicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // createOrdenpView undelegateEvents
                if ( this.createOrdenpView instanceof Backbone.View ){
                    this.createOrdenpView.stopListening();
                    this.createOrdenpView.undelegateEvents();
                }

                // Redirect to edit orden
                Backbone.history.navigate(Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
