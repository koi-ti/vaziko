/**
* Class AsientoMovimientosListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoMovimientosListView = Backbone.View.extend({

        el: '#wrapper-movimientos',
        parameters: {
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Valor
            this.$valor = $('#movimiento_valor');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.listenTo( this.collection, 'totalize', this.totalize );

            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view task by model
        * @param Object asientoMovimientoModel Model instance
        */
        addOne: function (asientoMovimientoModel) {
            var view = new app.AsientoMovimientosItemView({
                model: asientoMovimientoModel,
                parameters: {
                    edit: this.parameters.edit,
                    nuevo: this.parameters.nuevo,
                    naturaleza: this.parameters.naturaleza
                }
            });
            asientoMovimientoModel.view = view;
            this.$el.append(view.render().el);
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.$el.empty();
            this.collection.forEach(this.addOne, this);

            // Totalizar && fire libraties
            this.totalize(this.$valor.inputmask('unmaskedvalue'));
            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initInputMask == 'function')
                window.initComponent.initInputMask();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();
        },

        totalize: function (valor) {
            var data = this.collection.totalize(valor);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.el);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner(this.el);
        }
   });

})(jQuery, this, this.document);
