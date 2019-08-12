/**
* Class AsientoMovimientosItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoMovimientosItemView = Backbone.View.extend({

        tagName: 'div',
        template: _.template(($('#add-movimiento-asiento2-item-tpl').html() || '')),
        parameters: {
            edit: false,
            naturaleza: null
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            if (this.parameters.edit) {
                if (this.model.get('type') == 'F') {
                    this.template = _.template(($('#edit-asiento-factura-item').html() || ''));
                } else if (this.model.get('type') == 'FP') {
                    this.template = _.template(($('#edit-asiento-facturap-item').html() || ''));
                } else if (this.model.get('type') == 'IP') {
                    this.template = _.template(($('#edit-asiento-inventario-item').html() || ''));
                }
            } else {
                if (this.model.get('type') == 'F') {
                    this.template = _.template(($('#add-info-factura-item').html() || ''));
                } else if (this.model.get('type') == 'FP') {
                    this.template = _.template(($('#add-info-facturap-item').html() || ''));
                } else if (this.model.get('type') == 'IP') {
                    this.template = _.template(($('#add-info-inventario-item').html() || ''));
                }
            }

            // Events Listener
            this.listenTo(this.model, 'change', this.render);
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
                attributes.nuevo = this.parameters.nuevo;
                attributes.naturaleza = this.parameters.naturaleza;
            this.$el.html(this.template(attributes));
            return this;
        }
    });

})(jQuery, this, this.document);
