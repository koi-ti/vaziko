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
                var _this = this,
                    data = window.Misc.formToJson( e.target );

                var model = _.find( this.parameters.collection.models, function(item) {
                    return item.get('id') == _this.parameters.model.id;
                });

                if(model instanceof Backbone.Model ) {
                    model.save( data ,{
                        success : function(model, resp) {
                            if(!_.isUndefined(resp.success)) {
                                window.Misc.removeSpinner( _this.parameters.wrapper );

                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                alertify.success( resp.msg );
                                _this.parameters.collection.fetch();
                                _this.$modal.modal('hide');
                            }
                        },
                        error : function(model, error) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            alertify.error(error.statusText)
                        }
                    });
                }
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
