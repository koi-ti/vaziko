/**
* Class EmpaquesProductopPreCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EmpaquesProductopPreCotizacionListView = Backbone.View.extend({

        el: '#browse-precotizacion-producto-empaques-list',
        events: {
            'click .item-producto-empaque-precotizacion-remove': 'removeOne',
            'click .item-producto-empaque-precotizacion-edit': 'editOne',
            'click .item-producto-empaque-precotizacion-success': 'successEdit'
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Render total
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if (this.parameters.dataFilter.precotizacion2)
                this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object precotizacion9Model Model instance
        */
        addOne: function (precotizacion9Model) {
            var view = new app.EmpaquesProductopPreCotizacionItemView({
                model: precotizacion9Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            precotizacion9Model.view = view;
            this.$el.append( view.render().el );

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
        * store
        * @param form element
        */
        storeOne: function (data, form) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var precotizacion9Model = new app.PreCotizacion9Model();
            precotizacion9Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        window.Misc.clearForm(form);
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
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
                var cancelConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: { materialp_nombre: model.get('materialp_nombre')},
                        template: _.template( ($('#precotizacion-delete-empaque-confirm-tpl').html() || '') ),
                        titleConfirm: 'Eliminar empaque de producción',
                        onConfirm: function () {
                            model.view.remove();
                            _this.collection.remove(model);
                            _this.totalize();
                        }
                    }
                });

                cancelConfirm.render();
            }
        },

        /**
        * Event edit item
        */
        editOne: function(e){
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            var view = new app.EmpaquesProductopPreCotizacionItemView({
                model: model,
                parameters: {
                    action: 'edit',
                }
            });
            model.view.$el.replaceWith( view.render().el );
            this.ready();
        },

        /**
        * Event success edit item
        */
        successEdit: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            var dimensiones = this.$('#precotizacion9_medidas_' + model.get('id')).val();
                cantidad = this.$('#precotizacion9_cantidad_' + model.get('id')).val();
                valor = this.$('#precotizacion9_valor_unitario_' + model.get('id')).inputmask('unmaskedvalue');

            if (!dimensiones.length || !cantidad.length || !valor) {
                alertify.error('Ningun campo puede ir vacio.');
                return;
            }

            model.set({'precotizacion9_medidas': dimensiones, 'precotizacion9_cantidad': cantidad, 'precotizacion9_valor_unitario': valor});
            this.collection.trigger('reset');
        },

        /**
        * Event success edit item
        */
        ready: function () {
            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * Render totales the collection
        */
        totalize: function(){
            var data = this.collection.totalize();

            if(this.$total.length) {
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        },
   });

})(jQuery, this, this.document);