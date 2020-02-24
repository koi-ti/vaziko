/**
* Class CreateTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTerceroView = Backbone.View.extend({

        el: '#tercero-create',
        template: _.template( ($('#add-tercero-tpl').html() || '') ),
        events: {
            'submit #form-tercero': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Events
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

            this.spinner = this.$('.spinner-main');
            this.$form = this.$('#form-tercero');
            this.$formAccounting = this.$('#form-accounting');

            this.ready();
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), window.Misc.formToJson(this.$formAccounting));
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

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();
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

                // Redirect to edit tercero
                window.Misc.redirect(window.Misc.urlFull(Route.route('terceros.edit', {terceros: resp.id})));
            }
        }
    });

})(jQuery, this, this.document);
