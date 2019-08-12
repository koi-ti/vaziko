/**
* Class ShowAsientoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAsientoView = Backbone.View.extend({

        el: '#asientos-show',
        events: {
            'click .reverse-asiento': 'reverseAsiento'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Model exist
            this.asientoCuentasList = new app.AsientoCuentasList();

            // Reference views
            this.spinner = this.$('.spinner-main');
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Reverse asiento
        */
        reverseAsiento: function (e) {
            e.preventDefault();

            var _this = this;

            var editConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#asiento-reverse-confirm-tpl').html() || '') ),
                    titleConfirm: 'Editar asiento contable',
                    onConfirm: function () {
                        window.Misc.setSpinner(_this.spinner);
                        $.get(window.Misc.urlFull(Route.route('asientos.reverse', {asientos: _this.model.get('id')})), function (resp) {
                            window.Misc.removeSpinner(_this.spinner);
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

                                // Redirect to Content Course
                                window.Misc.redirect(window.Misc.urlFull(Route.route('asientos.edit', {asientos: resp.id}), {trigger: true}));
                            }
                        });
                    }
                }
            });

            editConfirm.render();
        },
    });

})(jQuery, this, this.document);
