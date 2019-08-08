/**
* Class AsientoCuentasNifItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasNifItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-asienton2-item-tpl').html() || '') ),
        templateInfo: _.template( ($('#show-info-asienton2-tpl').html() || '') ),
        templateInfoFacturaItem: _.template( ($('#add-info-factura-item').html() || '') ), // Factura
        templateInfoFacturapItem: _.template( ($('#add-info-facturap-item').html() || '') ), // Facturap
        templateInfoInventarioItem: _.template( ($('#add-info-inventario-item').html() || '') ), // Inventario
        events: {
            'click .item-asiento2-show-info': 'showInfo'
        },
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.$modalInfo = $('#modal-asiento-show-info-component');
            this.asientoMovimientosList = new app.AsientoMovimientosList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );

            this.listenTo( this.asientoMovimientosList, 'request', this.loadSpinner );
            this.listenTo( this.asientoMovimientosList, 'sync', this.responseServer );
            this.listenTo( this.asientoMovimientosList, 'reset', this.addAll );
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;

            this.$tercero = {tercero_nit: attributes.tercero_nit, tercero_nombre: attributes.tercero_nombre};
            this.$naturaleza = attributes.asiento2_naturaleza;

            this.$el.html(this.template(attributes));
            return this;
        },

        /**
        * Show info asiento
        */
        showInfo: function () {
            var attributes = this.model.toJSON();

            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );

            // Wrapper Info
            this.$wrapGeneral = this.$modalInfo.find('#render-info-modal');

            // Count
            this.count = 0;

            // Get movimientos list
            this.asientoMovimientosList.fetch({ reset: true, data: { asiento2: this.model.get('id') } });

            // Open modal
            this.$modalInfo.modal('show');
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (AsientoMovModel) {
            var attributes = AsientoMovModel.toJSON();
                attributes.tercero = this.$tercero;
                attributes.naturaleza = this.$naturaleza;


            if (attributes.movimiento_tipo == 'F') {
                this.$wrapGeneral.empty().html(this.templateInfoFacturaItem(attributes));
                this.$wrapperList = this.$modalInfo.find('#browse-showinfo-factura-list');

            } else if ( attributes.movimiento_tipo == 'FP') {
                if (attributes.movimiento_nuevo) {
                    this.$wrapGeneral.empty().html(this.templateInfoFacturapItem(attributes));
                    return;
                } else {
                    if (this.count == 0) {
                        this.$wrapGeneral.empty().html(this.templateInfoFacturapItem(attributes));
                        this.$wrapperList = this.$modalInfo.find('#browse-showinfo-facturap-list');
                        this.count = this.count + 1;
                    }
                }

            } else if (attributes.movimiento_tipo == 'IP') {
                this.$wrapGeneral.empty().html(  this.templateInfoInventarioItem( attributes ) );
                this.$wrapperList = this.$modalInfo.find('#browse-showinfo-asiento-list');

            }

            var view = new app.AsientoMovimientosItemView({
                model: AsientoMovModel,
            });

            this.$wrapperList.append(view.render().el);
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.asientoMovimientosList.forEach(this.addOne, this);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.$wrapperList);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.$wrapperList);
        }
    });

})(jQuery, this, this.document);
