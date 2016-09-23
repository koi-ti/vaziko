/**
* Class CreateFacturapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturapView = Backbone.View.extend({

        el: '#modal-facturap-component',
        template: _.template( ($('#eval-rfacturap-tpl').html() || '') ),
        templateAdd: _.template( ($('#add-rfacturap-tpl').html() || '') ),
        templateCuotas: _.template( ($('#add-rfacturap2-tpl').html() || '') ),
        events: {
            'submit #form-create-facturap-component': 'onStoreItem',
            'change input#facturap1_factura': 'facturapChanged'
        },
        parameters: {
            data: { }
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Collection cuotas
            this.cuotasFPList = new app.CuotasFPList();

            // Events Listeners
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.listenTo( this.model, 'sync', this.responseServer );

            // Events Listeners
            this.listenTo( this.cuotasFPList, 'reset', this.addAll );
        },

        /*
        * Render View Element
        */
        render: function() {

            this.$el.find('.content-modal').html( this.template( this.parameters.data ) );
            this.$wraper = this.$el.find('.modal-body');
            this.$wraperForm = this.$('#content-invoice');
            this.$wraperError = this.$('#error-eval-facturap');

            // this.$fieldFactura = this.$('#facturap1_factura');
            // this.$fieldFactura.off('change');
            // this.$fieldFactura.on('change', this.facturapChanged);
            // $( "#dataTable tbody tr" ).on( "click", function() {
            // this.$fieldFactura.removeEventListener();
            // this.$fieldFactura.addEventListener('change', this.facturapChanged);

            // Hide errors
            this.$wraperError.hide().empty();

            // Open modal
            this.$el.modal('show');
		},

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Model exist
                if( this.model.id != undefined ) {
                    // Insert item
                    this.collection.trigger( 'store', data );
                }else{
                    // Create model
                    this.model.save( data, {patch: true, silent: true} );
                }
            }
        },

        /*
        * Facturap changed
        */
        facturapChanged: function(e) {

            // Hide errors
            this.$wraperError.hide().empty();
            // Empty Form
            this.$wraperForm.empty();

            // Evaluate account
            window.Misc.evaluateFacturap({
                'facturap': $(e.currentTarget).val(),
                'naturaleza': this.parameters.data.asiento2_naturaleza,
                'tercero': this.parameters.data.tercero_nit,
                'wrap': this.$wraper,
                'callback': (function (_this) {
                    return function ( resp )
                    {
                        if(resp.actions) {
                            // stuffToDo Response success
                            var stuffToDo = {
                                'add' : function() {
                                    // AddFacturapView
                                    _this.$wraperForm.html( _this.templateAdd( ) );
                                    _this.ready();
                                },
                                'quota' : function() {
                                    // QuotaFacturapView
                                    _this.$wraperForm.html( _this.templateCuotas( ) );
                                    _this.$wraperCuotas = _this.$('#browse-rfacturap2-list');

                                    // Get cuotas list
                                    _this.cuotasFPList.fetch({ reset: true, data: { facturap1: resp.facturap } });
                                }
                            };

                            if (stuffToDo[resp.action]) {
                                stuffToDo[resp.action]();
                            }

                        }else{
                            // No actions
                            if(!_.isUndefined(resp.message) && !_.isNull(resp.message) && resp.message != '') {
                                _this.$wraperError.empty().append(resp.message);
                                _this.$wraperError.show();
                            }
                        }
                    }
                })(this)
            });
        },


        /**
        * Render view task by model
        * @param Object Facturap2Model Model instance
        */
        addOne: function (Facturap2Model) {
            var view = new app.CuotasFPListView({
                model: Facturap2Model
            });

            this.$wraperCuotas.append( view.render().el );

            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.cuotasFPList.forEach( this.addOne, this );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modal
                    this.$el.modal('hide');
                }
            }
        }
    });

})(jQuery, this, this.document);
