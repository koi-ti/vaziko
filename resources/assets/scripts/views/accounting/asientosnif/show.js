/**
* Class ShowAsientoNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAsientoNifView = Backbone.View.extend({

        el: '#asientosnif-show',

        /**
        * Constructor Method
        */
        initialize: function () {
            this.asientoNifCuentasList = new app.AsientoNifCuentasList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoNifCuentasListView({
                collection: this.asientoNifCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
