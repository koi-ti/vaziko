/**
* Class ComponentSearchCuentaView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchCuentaView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-plancuenta-component-tpl').html() || '') ),

		events: {
			'change input.plancuenta-koi-component': 'cuentaChanged',
            'click .btn-koi-search-plancuenta-component': 'searchCuenta',
            'click .btn-search-koi-search-plancuenta-component': 'search',
            'click .btn-clear-koi-search-plancuenta-component': 'clear',
            'click .a-koi-search-plancuenta-component-table': 'setCuenta'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-component');
		},

		searchCuenta: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchCuenta = this.$('#koi_search_plancuentas_cuenta');
            this.$searchName = this.$('#koi_search_plancuentas_nombre');

            this.$plancuentasSearchTable = this.$modalComponent.find('#koi-search-plancuenta-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

			this.$inputCentro = this.$("#"+this.$inputContent.attr("data-centro"));
			this.$inputBase = this.$("#"+this.$inputContent.attr("data-base"));
			this.$inputValor = this.$("#"+this.$inputContent.attr("data-valor"));
			this.$inputTasa = this.$("#"+this.$inputContent.attr("data-tasa"));

            this.plancuentasSearchTable = this.$plancuentasSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('plancuentas.index') ),
                    data: function( data ) {
                        data.plancuentas_cuenta = _this.$searchCuenta.val();
                        data.plancuentas_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentas_cuenta', name: 'plancuentas_cuenta' },
                    { data: 'plancuentas_nivel', name: 'plancuentas_nivel' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'plancuentas_naturaleza', name: 'plancuentas_naturaleza' },
                    { data: 'plancuentas_tercero', name: 'plancuentas_tercero' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-plancuenta-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '10%',
                        searchable: false
                    },
                    {
                        targets: 3,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return data == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return data ? 'Si' : 'No';
                        }
                    }
                ]
			});

        	// Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setCuenta: function(e) {
			e.preventDefault();

	        var data = this.plancuentasSearchTable.row( $(e.currentTarget).parents('tr') ).data();

			this.$inputContent.val( data.plancuentas_cuenta );
			this.$inputName.val( data.plancuentas_nombre );
			this.$inputName.val( data.plancuentas_nombre );

			// Clear centro costo
            if(this.$inputCentro.length) {
        		this.$inputCentro.val('').trigger('change');
            }

            // Clear base
            if(this.$inputBase.length) {
				this.$inputBase.prop('readonly', true);
			}

			this.$modalComponent.modal('hide');

		    // Other actions
            this.actions(data);
		},

		search: function(e) {
			e.preventDefault();

		    this.plancuentasSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

			this.$searchCuenta.val('');
			this.$searchName.val('');

			this.plancuentasSearchTable.ajax.reload();
		},

		cuentaChanged: function(e) {
			var _this = this;

			// References
			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$inputBase = this.$("#"+$(e.currentTarget).attr("data-base"));
			this.$inputTasa = this.$("#"+$(e.currentTarget).attr("data-tasa"));

			this.$inputValor = this.$("#"+$(e.currentTarget).attr("data-valor"));
			this.$inputCentro = this.$("#"+$(e.currentTarget).attr("data-centro"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var cuenta = this.$inputContent.val();

			// Before eval clear data
			this.$inputName.val('');

			// Clear centro costo
            if(this.$inputCentro.length) {
        		this.$inputCentro.val('').trigger('change');
            }

            // Clear base
            if(this.$inputBase.length) {
				this.$inputBase.prop('readonly', true);
			}

			// Clear tasa
            if(this.$inputTasa.length) {
				this.$inputTasa.val('');
			}

			if(!_.isUndefined(cuenta) && !_.isNull(cuenta) && cuenta != '') {
				// Get plan cuenta
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('plancuentas.search')),
	                type: 'GET',
	                data: { plancuentas_cuenta: cuenta },
	                beforeSend: function() {
						window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
                   if(resp.success) {
	                    // Set name
	                    if(!_.isUndefined(resp.plancuentas_nombre) && !_.isNull(resp.plancuentas_nombre)){
							_this.$inputName.val(resp.plancuentas_nombre);
	                    }

	                    // Other actions
	                    _this.actions(resp);
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });

	     	}
		},

		/**
        * Other actions on set cuenta
        */
		actions: function (data) {
            // Eval base
        	if(this.$inputBase.length) {
            	if(!_.isUndefined(data.plancuentas_tasa) && !_.isNull(data.plancuentas_tasa) && data.plancuentas_tasa > 0) {
            		// Case plancuentas_tasa eval value
        			this.$inputBase.prop('readonly', false);
     				this.$inputValor.val( (data.plancuentas_tasa * this.$inputBase.val()) );
            	}else{
            		// Case without plancuentas_tasa
            		this.$inputBase.val('');
            	}
            }

            // Eval centro costo
            if(this.$inputCentro.length) {
            	if(!_.isUndefined(data.plancuentas_centro) && !_.isNull(data.plancuentas_centro) && data.plancuentas_centro > 0) {
            		this.$inputCentro.val( data.plancuentas_centro ).trigger('change');
            	}
            }

            // Eval tasa
            if(this.$inputTasa.length) {
            	if(!_.isUndefined(data.plancuentas_tasa) && !_.isNull(data.plancuentas_tasa) && data.plancuentas_tasa > 0) {
            		this.$inputTasa.val( data.plancuentas_tasa );
            	}else{
					this.$inputTasa.val('');
				}
			}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);
