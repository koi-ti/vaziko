/**
* Class ProductopPreCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopPreCotizacionListView = Backbone.View.extend({

        el: '#browse-precotizacion-productop-list',
        events: {
            'click .item-precotizacion-producto-remove': 'removeOne',
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

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {precotizacion2_precotizacion1: this.parameters.dataFilter.precotizacion2_precotizacion1}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {
        },

        /**
        * Render view contact by model
        * @param Object precotizacion2Model Model instance
        */
        addOne: function (precotizacion2Model) {
            var view = new app.ProductopPreCotizacionItemView({
                model: precotizacion2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            precotizacion2Model.view = view;
            this.$el.append( view.render().el );
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

            // Function confirm delete item
            this.confirmDelete( model );
        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { productop_nombre: model.get('productop_nombre') },
                    template: _.template( ($('#precotizacion-productop-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar producto',
                    onConfirm: function () {
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
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
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
