/**
* Class ShowProductopView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductopView = Backbone.View.extend({

        el: '#terceros-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.tipsList = new app.TipsList();
                this.areasList = new app.AreasList();
                this.maquinasList = new app.MaquinasList();
                this.materialesList = new app.MaterialesList();
                this.acabadosList = new app.AcabadosList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
       		// Tips list
            this.tipsListView = new app.TipsListView( {
                collection: this.tipsList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-tips'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.areasListView = new app.AreasListView( {
                collection: this.areasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-areas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.maquinasListView = new app.MaquinasListView( {
                collection: this.maquinasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-maquinas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Materiales list
            this.materialesListView = new app.MaterialesListView( {
                collection: this.materialesList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-materiales'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Acabados list
            this.acabadosListView = new app.AcabadosListView( {
                collection: this.acabadosList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-acabados'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });
        }
    });

})(jQuery, this, this.document);
