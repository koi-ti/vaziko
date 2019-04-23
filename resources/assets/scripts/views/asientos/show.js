/**
* Class ShowAsientoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAsientoView = Backbone.View.extend({

        el: '#asientos-show',
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.asientoCuentasList = new app.AsientoCuentasList();

                // Reference views
                this.spinner = this.$('.spinner-main');
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        },

        anularAsiento: function(e) {
            e.preventDefault();

            var model = this.model,
                _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#asiento-anular-confirm-tpl').html() || '') ),
                    titleConfirm: 'Anular asiento',
                    onConfirm: function () {
                        
                    }
                }
            });

            cancelConfirm.render();
        }
    });

})(jQuery, this, this.document);
