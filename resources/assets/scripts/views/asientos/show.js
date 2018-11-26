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
            'click .delete-asiento': 'deleteAsiento'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
                this.asientoCuentasList = new app.AsientoCuentasList();

                // Reference views
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
                    wrapper: this.el,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        },

        deleteAsiento: function(e) {
            e.preventDefault();
            var _this = this;
                model = this.model;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#asiento-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar asiento',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.el );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('asientos.index')));
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        }
    });

})(jQuery, this, this.document);
