/**
* Class InventarioActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.InventarioActionView = Backbone.View.extend({
    	el: 'body',

    	events:{
            'submit #form-create-inventario-component-source': 'onStoreInventario',
    	},

        parameters: {
            data: { },
        },

        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-inventory-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize : function( opts )
        {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalIn = this.$('#modal-inventario-component');

            // Collection item rollo
            this.itemRolloINList = new app.ItemRolloINList();
            // Collection series producto
            this.productoSeriesINList = new app.ProductoSeriesINList();

            // Events Listeners
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );
            this.listenTo( this.itemRolloINList, 'store', this.onStoreItemRolloInventario );

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function()
        {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'metrado': function() {
                        if (resp.tipo === 'E') {
                            // Code...
                        }else {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo( ) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Salidas de productos metrados');
                        }

                        // Reference inventario
                        _this.metrajeReference(resp);
                    },
                    'series': function() {
                        console.log('series');
                        // Reference inventario
                        _this.serieReference(resp);
                    },
                    unidades: function() {
                        console.log('unidades');
                        // Reference inventario
                        _this.unidadesReference(resp);
                    }
                };
            if (stuffToDo[resp.action]) {
                this.parameters.data = $.extend({}, this.parameters.data);
                this.parameters.data.action = resp.action;
                stuffToDo[resp.action]();
            }
		},

        /**
        * Reference add RolloMetrado
        */
        metrajeReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code..
            }else {
                //Salidas
                this.$wraperItemRollo = this.$('#browse-chooseitemtollo-list');
                this.itemRolloINList.fetch({ reset: true, data: { producto: attributes.producto,   sucursal: attributes.data.sucursal } });
            }

            // Open modal
            this.$modalIn.modal('show');
        },
        /**
        * Reference add Series
        */
        serieReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code...
            }else {
                // Salidas
                this.parameters.data = $.extend({}, this.parameters.data);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * Reference add No series No metros
        */
        unidadesReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code...
            }else {
                // Salidas
                this.parameters.data = $.extend({}, this.parameters.data);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (ItemRolloModel, choose)
        {
            choose || (choose = false);

            var view = new app.ItemRolloINListView({
                model: ItemRolloModel,
                parameters: {
                    choose: choose
                }
            });
            this.$wraperItemRollo.append( view.render().el );
            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllItemRolloInventario: function ()
        {
            var _this = this;
            this.itemRolloINList.forEach(function(model, index) {
                _this.addOneItemRolloInventario(model, true)
            });
        },
        /*
        * Validate Carro temporal
        */
        onStoreInventario: function (e)
        {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.parameters.data = $.extend({}, this.parameters.data);
                this.parameters.data.items = window.Misc.formToJson(e.target);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * fires libraries js
        */
        ready: function ()
        {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        /**
        * Respose of de server
        */
        responseServer: function ( model, resp, opts )
        {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modals
                    this.$modalIn.modal('hide');

                    // Clear Form of car temp
                    if (!_.isUndefined(this.parameters.form))
                        window.Misc.clearForm(this.parameters.form);
                }
            }
        }

    });
})(jQuery, this, this.document);
