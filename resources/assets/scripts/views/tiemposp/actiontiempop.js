/**
* Class TiempopActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopActionView = Backbone.View.extend({

        el: '#tiempop-content-section',
        template: _.template(($('#edit-tiempop-tpl').html() || '')),
        events: {
            'click .submit-edit-tiempop': 'submitForm',
            'submit #form-edit-tiempop': 'onStore',
        },
        parameters: {
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-edit-tiempop');
            this.$form =  this.$('#form-edit-tiempop');
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.parameters.model;
            this.$modal.find('.modal-title').text( 'Tiempo de producción - Editar # '+ attributes.id );
            this.$modal.find('.content-modal').empty().html( this.template( attributes ) );

            this.ready();
		},

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$form.submit();
        },

        /**
        *   Event store
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var _this = this;
                var data = window.Misc.formToJson( e.target );
                    data.tiempo_id = this.parameters.model.id;

                // Update tiempop
                $.ajax({
                    url: window.Misc.urlFull( Route.route( 'tiemposp.update') ),
                    data: data,
                    type: 'PUT',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
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

                        alertify.success( resp.msg );
                        _this.$modal.modal('hide');
                        _this.model.fetch();
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }
        },

    	/**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
        },
    });

})(jQuery, this, this.document);
