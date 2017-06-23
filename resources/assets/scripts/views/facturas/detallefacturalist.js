/**
* Class DetalleFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturaView = Backbone.View.extend({

        el: '#browse-detalle-factura-list',
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // References
            this.$facturado = this.$('#subtotal-facturado');
            // this.$subtotal = this.$('#subtotal-total');
            // this.$iva = this.$('#iva-total');
            // this.$rtfuente = this.$('#rtfuente-total');
            // this.$rtica = this.$('#rtica-total');
            // this.$rtiva = this.$('#rtiva-total');
            // this.$total = this.$('#total-total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (factura2Model) {
            var view = new app.DetalleFacturaItemView({
                model: factura2Model,
                parameters:{
                    call: this.parameters.call,
                }
            });
            factura2Model.view = view;
            this.$el.append( view.render().el );

            //totalize actually in collection
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
            }

            // if(this.$subtotal.length) {
            //     this.$subtotal.html( window.Misc.currency( Math.round( data.subtotal ) ) );
            // }

            // var iva = data.subtotal * 0.19;
            // if(this.$iva.length) {
            //     this.$iva.html( window.Misc.currency( Math.round( iva ) ) );
            // }

            // var total = data.subtotal + iva;
            // if(this.$total.length) {
            //     this.$total.html( window.Misc.currency( Math.round( total ) ) );
            // }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);
