/**
* Class AsientoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoActionView = Backbone.View.extend({

        el: '#asiento-content-section',
        templateOrdenp: _.template( ($('#searchordenp-asiento-tpl').html() || '') ),
        templateFacturap: _.template( ($('#rfacturap-asiento-tpl').html() || '') ),
        templateAddFacturap: _.template( ($('#add-rfacturap-asiento-tpl').html() || '') ),
        templateCuotasFacturap: _.template( ($('#add-rfacturap2-asiento-tpl').html() || '') ),
        events: {
            'submit #form-create-ordenp-asiento-component-source': 'onStoreItemOrdenp',
            'submit #form-create-asiento-component-source': 'onStoreItemFacturap',
            'change input#facturap1_factura': 'facturapChanged'
        },
        parameters: {
            data: { },
            actions: { }
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalOp = this.$('#modal-asiento-ordenp-component');
            this.$modalFp = this.$('#modal-asiento-facturap-component');

			// Collection cuotas
			this.cuotasFPList = new app.CuotasFPList();

			// Events Listeners
            this.listenTo( this.cuotasFPList, 'reset', this.addAllCuotasFacturap );
        },

        /*
        * Render View Element
        */
        render: function() {
    		this.runAction();
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
        * Run actions
        */
        runAction: function( ) {
            var resp = this.evaluateNextAction(),
        		_this = this,
	            stuffToDo = {
	                'facturap' : function() {
	                    _this.$modalFp.find('.content-modal').empty().html( _this.templateFacturap( _this.parameters.data ) );

	                    // Reference facturap
	                   	_this.referenceFacturap();

	                },

	                'ordenp' : function() {
	 	            	_this.$modalOp.find('.content-modal').empty().html( _this.templateOrdenp( _this.parameters.data ) );
	                 	// Reference ordenp
	            		_this.referenceOrdenp();
	                },

	                'store' : function() {
	                	console.log( 'Insertando' );
	                }
	            };

            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
        },

        /**
        * Evaluate first action account
        */
        evaluateNextAction: function() {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                action = this.parameters.actions[index];

                if(action.success == false) {
                    return action;
                }
            }

            return { action :'store' };
        },

        /**
        * Set success action
        */
        setSuccessAction: function(action) {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if(item.action == action) {
                    item.success = true;
                }
            }
        },

        /**
        * Reference facturap
        */
        referenceFacturap: function( ) {
        	var _this = this;

            this.$wraperFormFp = this.$('#content-invoice');
            this.$wraperErrorFp = this.$('#error-eval-facturap');

            // Hide errors
            this.$wraperErrorFp.hide().empty();

            // Open modal
            this.$modalFp.modal('show');
        },

        /**
        * Reference orden
        */
        referenceOrdenp: function( ) {
            var _this = this;

            this.$wraperFormOp = this.$modalOp.find('.content-modal');
            this.$wraperErrorOp = this.$('#error-search-orden-asiento2');

            // Hide errors
            this.$wraperErrorOp.hide().empty();

            // Open modal
            this.$modalOp.modal('show');
        },

        /**
        * Event add item ordenp
        */
        onStoreItemOrdenp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
    	        // var order = this.ordersSearchTable.row( $(e.currentTarget).parents('tr') ).data();
                // this.parameters.data.ordenp_codigo = order.id;

                // Set action success
				this.setSuccessAction('ordenp', this.parameters.actions);

				// Close modal
            	this.$modalOp.modal('hide');

				// Next action
	    		this.runAction();
            }
        },

        /*
        * Facturap changed
        */
        facturapChanged: function(e) {
        	// Hide errors
            this.$wraperErrorFp.hide().empty();
            // Empty Form
            this.$wraperFormFp.empty();

            // Evaluate account
            window.Misc.evaluateFacturap({
                'facturap': $(e.currentTarget).val(),
                'naturaleza': this.parameters.data.asiento2_naturaleza,
                'tercero': this.parameters.data.tercero_nit,
                'wrap': this.$wraperFormFp,
                'callback': (function (_this) {
                    return function ( resp )
                    {
                        if(resp.actions) {
                            // stuffToDo Response success
                            var stuffToDo = {
                                'add' : function() {
                                    // AddFacturapView
                                    _this.$wraperFormFp.html( _this.templateAddFacturap( ) );
                                    _this.ready();
                                },
                                'quota' : function() {
                                    // QuotaFacturapView
                                    _this.$wraperFormFp.html( _this.templateCuotasFacturap( ) );
                                    _this.$wraperCuotasFp = _this.$('#browse-rfacturap2-list');

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
                                _this.$wraperErrorFp.empty().append(resp.message);
                                _this.$wraperErrorFp.show();
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
        addOneCuotaFacturap: function (Facturap2Model) {
            var view = new app.CuotasFPListView({
                model: Facturap2Model
            });

            this.$wraperCuotasFp.append( view.render().el );

            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllCuotasFacturap: function () {
            this.cuotasFPList.forEach( this.addOneCuotaFacturap, this );
        },

        /**
        * Event add item facturap
        */
        onStoreItemFacturap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Model exist
                // if( this.model.id != undefined ) {
                //     // Insert item
                //     this.collection.trigger( 'store', data );
                // }else{
                //     // Create model
                //     this.model.save( data, {patch: true, silent: true} );
                // }

                // Set action success
				this.setSuccessAction('facturap', this.parameters.actions);

				// Close modal
            	this.$modalFp.modal('hide');

				// Next action
	    		this.runAction();
            }
        }
    });

})(jQuery, this, this.document);


// initialize : function( opts ) {
//     // extends parameters
//     if( opts !== undefined && _.isObject(opts.parameters) )
//         this.parameters = $.extend({}, this.parameters, opts.parameters);

//     // Collection cuotas
//     this.cuotasFPList = new app.CuotasFPList();

//     // Events Listeners
//     this.listenTo( this.collection, 'sync', this.responseServer );
//     this.listenTo( this.model, 'sync', this.responseServer );

//     // Events Listeners
//     this.listenTo( this.cuotasFPList, 'reset', this.addAll );
// },

// /**
// * Event add item Asiento Cuentas
// */
// onStoreItem: function (e) {
//     if (!e.isDefaultPrevented()) {
//         e.preventDefault();

//         // Prepare global data
//         var data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

//         // Model exist
//         if( this.model.id != undefined ) {
//             // Insert item
//             this.collection.trigger( 'store', data );
//         }else{
//             // Create model
//             this.model.save( data, {patch: true, silent: true} );
//         }
//     }
// },

// /**
// * response of the server
// */
// responseServer: function ( model, resp, opts ) {
//     if(!_.isUndefined(resp.success)) {
//         if( resp.success ) {
//             // Close modal
//             this.$el.modal('hide');
//         }
//     }
// }
