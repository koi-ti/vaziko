/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#producto-show',
        templateItemsRollo: _.template( ($('#itemrollo-product-tpl').html() || '') ),
        events: {
            'click .get-info-availability': 'getInfoAvailability'
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            // Referencie fields
            this.$('#browse-prodbode-table').hide();
            this.sucursal = null;
            this.call = null;

            // Collection
            this.itemRolloINList = new app.ItemRolloINList();
            this.prodbodeList = new app.ProdBodeList();
        },

        /**
        * Event show series products father's OR
        * Event show metros in rollos
        */
        getInfoAvailability: function(e){
            e.preventDefault();

            if (this.$(e.target).attr('data-action') === 'rollos') {

                // sucursal
                this.sucursal = this.$(e.target).attr('data-sucursal');

                // Modale open
                this.$modalGeneric = $('#modal-product-generic');
                this.$modalGeneric.modal('show');
                this.$modalGeneric.find('.content-modal').empty().html(this.templateItemsRollo( ) );
                this.$modalGeneric.find('.modal-title').text( 'Productos metrados' );
                
                this.referenceViews();
            }

            if (this.$(e.target).attr('data-action') === 'series' && this.prodbodeList.length == 0){
                this.call = true;
                this.$('#browse-prodbode-table').show();
                this.referenceViews();
            }
        },

        /**
        * Reference to views
        */
        referenceViews: function () {
            // Detalle prodBode list
            this.prodbodeListView = new app.ProdbodeListView({
                collection: this.prodbodeList,
                parameters: {
                    dataFilter: {
                        'producto_id': this.model.get('id'),
                        'call': this.call
                    }
                }
            });

            // Detalle item rollo list
            this.itemRolloListView = new app.ItemRolloListView({
                collection: this.itemRolloINList,
                parameters: {
                    choose: false,
                    show: true,
                    dataFilter: {
                        'producto_id': this.model.get('id'),
                        'sucursal': this.sucursal,
                    }
                }
            });
        }
    });
})(jQuery, this, this.document);
