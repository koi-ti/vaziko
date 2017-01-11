/**
* Class ProductopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-productop-list',
        events: {
            'click .item-orden-producto-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$unidades = this.$('#subtotal-cantidad');
            this.$subtotal = this.$('#subtotal-total');
            this.$iva = this.$('#iva-total');
            this.$total = this.$('#total-total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden2_orden: this.parameters.dataFilter.orden2_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp2Model Model instance
        */
        addOne: function (ordenp2Model) {
            var view = new app.ProductopOrdenItemView({
                model: ordenp2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            ordenp2Model.view = view;
            this.$el.prepend( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                            _this.collection.remove(model);

                            // Update total
                            _this.totalize();
                        }
                    }
                });

            }
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$unidades.length) {
                this.$unidades.html( data.unidades );
            }

            if(this.$subtotal.length) {
                this.$subtotal.html( window.Misc.currency(data.subtotal) );
            }

            if(this.$iva.length) {
                this.$iva.html( window.Misc.currency(data.iva) );
            }

            if(this.$total.length) {
                this.$total.html( window.Misc.currency(data.total) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);