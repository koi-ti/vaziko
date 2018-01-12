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

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.asientoCuentasList = new app.AsientoCuentasList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.el,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);
