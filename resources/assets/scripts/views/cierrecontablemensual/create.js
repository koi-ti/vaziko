/**
* Class CreateCierreContableMensualView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCierreContableMensualView = Backbone.View.extend({

        el: '#cierremensual-main',
        events: {
            'click .sumbit-close-month': 'submitForm',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Reference form
            this.$form = this.$('#form-close-month');

            // Listen events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            this.ready();
        },

        /**
        * Event submit form
        */
        submitForm: function (e) {
            var _this = this;
            var msgConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#close-accounting-mensual-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cierre contable mensual',
                    onConfirm: function () {
                        if (!e.isDefaultPrevented()) {
                            e.preventDefault();
                            _this.$form.submit();
                        }
                    }
                }
            });
            msgConfirm.render();
        },

        /**
        * Event Create Cierre
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var _this = this;
                // Create cierre
                $.ajax({
                    url: window.Misc.urlFull(Route.route('cierresmensuales.index')),
                    type: 'GET',
                    beforeSend: function () {
                        window.Misc.setSpinner(_this.el);
                    }
                })
                .done(function (resp) {
                    if (!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner(_this.el);
                        // response success or error
                        var text = resp.success ? resp.msg : resp.errors;
                        if (!resp.success) {
                            alertify.error(text);
                            return;
                        } else {
                            alertify.success(text);
                            return;
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.el);
                    alertify.error(thrownError);
                });
            }
        },
        /**
        * Fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initSpinner == 'function')
                window.initComponent.initSpinner();
        }
    });

})(jQuery, this, this.document);
