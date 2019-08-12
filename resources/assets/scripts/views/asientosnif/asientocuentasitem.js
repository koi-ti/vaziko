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
