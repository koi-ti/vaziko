/**
* Class AsientoMovimientosItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoMovimientosItemView = Backbone.View.extend({

        tagName: 'tr',
        templateDetalleInventario: _.template( ($('#show-info-detalle-inventario').html() || '') ),
        templateDetalleFactura: _.template( ($('#show-info-detalle-factura').html() || '') ),
        templateDetalleFacturap: _.template( ($('#show-info-detalle-facturap').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function() {
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            
            if(attributes.movimiento_tipo == 'FH'){
                this.$el.html( this.templateDetalleFactura(attributes) );
            }else if( attributes.movimiento_tipo == 'IH') {
                if ( attributes.movimiento_tipo == 'IH' && !_.isNull( attributes.movimiento_serie ) ){
                    $('.first-row').text( 'Item' );
                    $('.second-row').text( 'Series' );
                }else{
                    $('.first-row').text( 'Item' );
                    $('.second-row').text( 'Metros (m)' );
                }

                this.$el.html( this.templateDetalleInventario(attributes) );
            }else if( attributes.movimiento_tipo == 'FP' ){
                this.$el.html( this.templateDetalleFacturap(attributes) );
            }
            return this;
        }
    });

})(jQuery, this, this.document);