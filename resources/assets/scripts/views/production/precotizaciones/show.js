/**
* Class ShowPreCotizacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowPreCotizacionView = Backbone.View.extend({

        el: '#precotizaciones-show',

        /**
        * Constructor Method
        */
        initialize: function () {
            // precotizacion codigo
            this.codigo = this.$('#precotizacion_codigo').val();

            // Attributes
            this.productopPreCotizacionList = new app.ProductopPreCotizacionList();
            this.spinner = this.$('.spinner-main');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopPreCotizacionListView = new app.ProductopPreCotizacionListView({
                collection: this.productopPreCotizacionList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        precotizacion: this.model.get('id')
                    }
               }
            });
        }
    });

})(jQuery, this, this.document);
