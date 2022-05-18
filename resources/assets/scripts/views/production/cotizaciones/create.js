/**
* Class CreateCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template(($('#add-cotizacion-tpl').html() || '')),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'submit #form-cotizaciones': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html(this.template(attributes));
            this.$form = this.$('#form-cotizaciones');
            this.spinner = this.$('#spinner-main');

            this.ready();
        },

        /**
        * Event submit productop
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initTimePicker == 'function')
                window.initComponent.initTimePicker();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();

            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initSpinner == 'function')
                window.initComponent.initSpinner();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.spinner);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.spinner);
            if (!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if (_.isObject(resp.errors)) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if (!resp.success) {
                    alertify.error(text);
                    return;
                }

                // createOrdenpView undelegateEvents
                if (this.createCotizacionView instanceof Backbone.View){
                    this.createCotizacionView.stopListening();
                    this.createCotizacionView.undelegateEvents();
                }

                // Redirect to edit cotizaciones
                window.Misc.redirect(window.Misc.urlFull(Route.route('cotizaciones.edit', {cotizaciones: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
