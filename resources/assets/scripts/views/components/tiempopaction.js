/**
* Class TiempopActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopActionView = Backbone.View.extend({

        el: 'body',
        templateTiempop: _.template(($('#edit-tiempop-tpl').html() || '')),
        templateTiempopOrdenp: _.template(($('#edit-tiempop-ordenp-tpl').html() || '')),
        events: {
            'click .submit-modal-tiempop': 'submitForm',
            'submit #form-edit-tiempop-component': 'updateModel'
        },
        parameters: {
            data: null,
            call: null
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-tiempop-edit-component');
            this.$wraper = this.$('#modal-tiempop-wrapper');
            this.$wraperError = this.$('#error-eval-tiempop');
            this.$form =  this.$('#form-edit-tiempop-component');
        },

        /*
        * Render View Element
        */
        render: function () {
            this.runAction();
		},

        runAction: function () {
            var attributes = this.model.toJSON();

            this.$modal.find('.modal-title').text('Tiempo de producción - Editar # '+ attributes.id);
            if (this.parameters.call == 'ordenp') {
                this.$modal.find('.content-modal').empty().html(this.templateTiempopOrdenp(attributes));

            } else if (this.parameters.call == 'tiemposp') {
                this.$modal.find('.content-modal').empty().html(this.templateTiempop(attributes));
            } else {
                return;
            }

            // Hide errors && Open modal
            this.$wraperError.hide().empty();
            this.$modal.modal('show');

            this.ready();
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
        updateModel: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                    data.call = this.parameters.call;
                this.model.save(data, {wait: true, patch: true, silent: true});

                // Hide modal
                if (this.parameters.call == 'ordenp') {
                    this.parameters.table.ajax.reload();
                    this.$modal.modal('hide');
                }
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initClockPicker == 'function')
                window.initComponent.initClockPicker();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();
        },
    });
})(jQuery, this, this.document);
