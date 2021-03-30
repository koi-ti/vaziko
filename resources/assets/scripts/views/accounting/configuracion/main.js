/**
* Class MainConfiguracionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainConfiguracionView = Backbone.View.extend({

        el: '#configuracion-main',
        events: {
            'submit #form-closing': 'submitForm',
            'submit #form-balance': 'submitForm'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Reference form
            this.spinner = this.$('.spinner-main');
        },

        /**
        * Event submit form
        */
        submitForm: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var form = $(e.currentTarget).attr('id'),
                    _this = this;

                // Validate form
                if (form == 'form-closing') {
                    var message = "Esta operación afectará los saldos iniciales de los Saldos Contables. Desea Continuar?",
                        title = "Cierre contable mensual",
                        state = "closing";
                } else {
                    var message = "Esta operación actualizara los saldos contables. Desea Continuar?",
                        title = "Actualizar saldos",
                        state = "balance";
                }

                var msgConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {message: message},
                        template: _.template(($('#config-confirm-tpl').html() || '')),
                        titleConfirm: title,
                        onConfirm: function () {
                            $.ajax({
                                url: window.Misc.urlFull(Route.route('configuracion.store')),
                                data: {state: state},
                                type: 'POST',
                                beforeSend: function () {
                                    window.Misc.setSpinner(_this.spinner);
                                }
                            })
                            .done(function (resp) {
                                if (!_.isUndefined(resp.success)) {
                                    window.Misc.removeSpinner(_this.spinner);
                                    // response success or error
                                    var text = resp.success ? resp.msg : resp.errors;
                                    if (!resp.success) {
                                        alertify.error(text);
                                        return;
                                    }

                                    window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('configuracion.index')));
                                }
                            })
                            .fail(function(jqXHR, ajaxOptions, thrownError) {
                                window.Misc.removeSpinner(_this.spinner);
                                alertify.error(thrownError);
                            });
                        }
                    }
                });
                msgConfirm.render();
            }
        },
    });

})(jQuery, this, this.document);
