/**
* Class ProductosView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductosView = Backbone.View.extend({

      	el: '#cotizaciones-content',
      	parameters:{
            cotizacion: null,
            call: null,
      	},
		events: {
            'submit #form-producto-component': 'addProducto',
            'change .change-tipomaterial': 'changeTipomaterial',
        },

        /**
        * Constructor Method
        */
        initialize: function(opts) {
        	// Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.$modalProducto = $('#modal-producto-component');

            this.$material = this.$('#cotizacion2_materialp');
        	this.$productoc = this.$('#cotizacion2_productoc');

            if( this.parameters.call == 'M'){
                this.changeProducto( this.parameters.cotizacion );
            }

            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        addProducto: function(e){
        	if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.cotizacion1 = this.parameters.cotizacion;
                this.collection.trigger( 'store' , data );
            }
        },

        changeTipomaterial:function (e){
            var _this = this;
            var tipo = this.$(e.currentTarget).val();

            if( typeof(tipo) !== 'undefined' && !_.isUndefined(tipo) && !_.isNull(tipo) && tipo != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('materialesp.index', {tipo: tipo}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );

                    _this.$material.empty().val(0);

                    _this.$material.append("<option value=></option>");
                    _.each(resp.data, function(item){
                        _this.$material.append("<option value="+item.id+">"+item.materialp_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }   
        },

        changeProducto: function( id ){
            var _this = this;
            
            $.ajax({
                url: window.Misc.urlFull( Route.route('cotizaciones.detalle.index', {cotizacion_id: id}) ),
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );

                _this.$productoc.empty().val(0);

                _this.$productoc.append("<option value=></option>");
                _.each(resp, function(item){
                    _this.$productoc.append("<option value="+item.cotizacion2_productoc+">"+item.cotizacion2_productoc+"</option>");
                });

            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    
                    // productosView undelegateEvents
                    if ( this.productosView instanceof Backbone.View ){
                        this.productosView.stopListening();
                        this.productosView.undelegateEvents();
                    }

                    // Close modals
                    this.$modalProducto.modal('hide');
                }
            }
        }
    });
})(jQuery, this, this.document);