/**
* Class MainRBalanceGeneralView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainRBalanceGeneralView = Backbone.View.extend({

        el: '#rbalancegeneral-main',
        template: _.template(($('#add-tercero-tpl').html() || '')),
        events: {
            'ifChanged #filter_tercero_check': 'changeTerceroCheck'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            this.$renderTercero = this.$('#render-tercero');
        },

        /**
        * Event tercero check
        */
        changeTerceroCheck: function (e) {
            e.preventDefault();

            // Clear render
            this.$renderTercero.empty().html();

            // Validate check
            var selected = this.$(e.currentTarget).is(':checked');
            if (selected) {
                this.$renderTercero.html(this.template());
            }
        }

    });

})(jQuery, this, this.document);
