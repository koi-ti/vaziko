/**
* Class MaterialesProductoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductoActionView = Backbone.View.extend({

        el: 'body',
        template: _.template(($('#edit-materialproducto-tpl').html() || '')),
        events: {
            'click .submit-edit-modal': 'submitForm',
            'submit #form-edit-resource-component': 'updateModel'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-edit-resource-component');
            this.$wraperError = this.$('#error-edit-resource-component');
            this.$form = this.$('#form-edit-resource-component');
        },

        /*
        * Render View Element
        */
        render: function() {
            this.runAction();
		},

        runAction: function() {
            var attributes = this.model.toJSON();

            this.$modal.find('.modal-title').text('Materiales de producción - Editar ('+attributes.proveedor_nombre+')');
            this.$modal.find('.content-modal').empty().html( this.template( attributes ) );

            // Hide errors && Open modal
            this.$wraperError.hide().empty();
            this.$modal.modal('show');

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Event submit productop
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        *   Event update
        */
        updateModel: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );

                var reg = /[A-Za-z]/;
                if( !reg.test( this.model.get('id') ) ){
                    this.model.set('change', true);
                }

                this.model.set('precotizacion3_cantidad', data.precotizacion3_cantidad);
                this.model.set('precotizacion3_medidas', data.precotizacion3_medidas);
                this.model.set('precotizacion3_valor_unitario', data.precotizacion3_valor_unitario);

                this.collection.trigger('reset');
                this.$modal.modal('hide');
            }
        },
    });
})(jQuery, this, this.document);
