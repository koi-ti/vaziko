/**
* Class CreatePlanCuentaNifView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePlanCuentaNifView = Backbone.View.extend({

        el: '#plancuentasnif-create',
        template: _.template( ($('#add-plancuentasnif-tpl').html() || '') ),
        events: {
            'change input#plancuentasn_cuenta': 'cuentaChanged',
            'submit #form-plancuentasnif': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Attributes
            this.$wraperForm = this.$('#render-form-plancuentasnif');

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
            this.$wraperForm.html( this.template(attributes) );

            this.$nivel = this.$('#plancuentasn_nivel');

            // to fire plugins
            this.ready();
		},

        ready: function () {
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();
        },

        cuentaChanged: function (e) {
            var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('plancuentasnif.nivel')),
                type: 'GET',
                data: { plancuentasn_cuenta: $(e.currentTarget).val() },
                beforeSend: function() {
                    _this.$nivel.val('');
                    window.Misc.setSpinner(_this.el);
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner(_this.el);
                if (resp.success) {
                    if (_.isUndefined(resp.nivel) || _.isNull(resp.nivel) || !_.isNumber(resp.nivel)) {
                        alertify.error('Ocurri?? un error definiendo el nivel de la cuenta, por favor verifique el n??mero de caracteres.');
                    }
                    _this.$nivel.val(resp.nivel);
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner(_this.el);
                alertify.error(thrownError);
            });
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.el);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.el);
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

                window.Misc.redirect(window.Misc.urlFull(Route.route('plancuentasnif.index')));
            }
        }
    });

})(jQuery, this, this.document);
