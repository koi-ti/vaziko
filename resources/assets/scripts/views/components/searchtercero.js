/**
* Class ComponentSearchTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchTerceroView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-tercero-component-tpl').html() || '')),
		events: {
			'change input.tercero-koi-component': 'terceroChanged',
            'click .btn-koi-search-tercero-component-table': 'searchTercero',
            'click .btn-search-koi-search-tercero-component': 'search',
            'click .btn-clear-koi-search-tercero-component': 'clear',
            'click .a-koi-search-tercero-component-table': 'setTercero'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-component');
		},

		searchTercero: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template({}));

            // References
            this.$searchNit = this.$('#koi_search_tercero_nit');
            this.$searchName = this.$('#koi_search_tercero_nombre');

            this.$tercerosSearchTable = this.$modalComponent.find('#koi-search-tercero-component-table');
			this.$inputContent = this.$("#" + $(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#" + this.$inputContent.attr("data-name"));
            this.$btnContact = this.$("#" + this.$inputContent.attr("data-contacto"));
            this.$inputOrden = this.$("#" + this.$inputContent.attr("data-orden2"));
            this.$inputFormapago = this.$("#" + this.$inputContent.attr("data-formapago"));
            this.$inputComision = this.$("#" + this.$inputContent.attr("data-comision"));
            this.$inputTiempop = this.$inputContent.data("tiempop");
            this.$inputProveedor = this.$inputContent.data("proveedor");
            this.checkVendedor = this.$inputContent.data("vendedor-estado");

            // Render vendedor in input
            this.$inputVendedor = this.$("#" + this.$inputContent.attr("data-vendedor"));
            this.$inputVendedorName = this.$("#" + this.$inputVendedor.attr("data-name"));

            this.tercerosSearchTable = this.$tercerosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: window.Misc.urlFull(Route.route('search.terceros')),
                    data: function (data) {
                        data.search = true;
                        data.tercero_nit = _this.$searchNit.val();
                        data.tercero_nombre = _this.$searchName.val();
                        data.tercero_tiempop = _this.$inputTiempop;
                        data.tercero_proveedor = _this.$inputProveedor;
                        data.tercero_vendedor_estado = _this.checkVendedor;
                        data.search_vendedor = _this.$inputVendedor.length;
                    }
                },
                columns: [
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function (data, type, full, row) {
                            return '<a href="#" class="a-koi-search-tercero-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6],
                        visible: false,
                        searchable: false
                    }
                ]
            });

            // Modal show
            this.ready();
            this.$modalComponent.modal('show');
        },

        setTercero: function (e) {
            e.preventDefault();

            var data = this.tercerosSearchTable.row($(e.currentTarget).parents('tr')).data();

            this.$inputContent.val(data.tercero_nit);
            this.$inputName.val(data.tercero_nombre);

            if (this.$inputOrden.length > 0) {
                this.$inputOrden.attr('data-tercero', data.id);
            }

            if (this.$inputComision.length > 0) {
                this.$inputComision.val(data.tercero_comision);
            }

            if (this.$inputFormapago.length > 0 || _.isNull(data.tercero_formapago)) {
                this.$inputFormapago.val(data.tercero_formapago);
            }

            if (this.$inputVendedor.length > 0) {
                this.$inputVendedor.val(!_.isNull(data.vendedor) ? data.vendedor.tercero_nit : '');
                this.$inputVendedorName.val(!_.isNull(data.vendedor) ? data.vendedor.tercero_nombre : '');
            }

            if (this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', data.id);
                this.$btnContact.attr('data-address-default', data.tercero_direccion);
                this.$btnContact.attr('data-address-nomenclatura-default', data.tercero_direccion_nomenclatura);
                this.$btnContact.attr('data-municipio-default', data.tercero_municipio);
            }

            this.$modalComponent.modal('hide');
        },

        search: function (e) {
            e.preventDefault();

            this.tercerosSearchTable.ajax.reload();
        },

        clear: function (e) {
            e.preventDefault();

            this.$searchNit.val('');
            this.$searchName.val('');

            this.tercerosSearchTable.ajax.reload();
        },

        terceroChanged: function (e) {
            var _this = this;

            this.$inputContent = $(e.currentTarget);
            this.$inputName = this.$("#" + $(e.currentTarget).attr("data-name"));
            this.$wraperConten = this.$("#" + $(e.currentTarget).attr("data-wrapper"));
            this.$btnContact = this.$("#" + this.$inputContent.attr("data-contacto"));
            this.$inputOrden = this.$("#" + this.$inputContent.attr("data-orden2"));
            this.$inputTiempop = this.$inputContent.data("tiempop");
            this.$inputProveedor = this.$inputContent.data("proveedor");
            this.checkVendedor = this.$inputContent.data("vendedor-estado");
            this.$inputFormapago = this.$("#" + this.$inputContent.attr("data-formapago"));
            this.$inputComision = this.$("#" + this.$inputContent.attr("data-comision"));

            // Render vendedor in input
            this.$inputVendedor = this.$("#" + this.$inputContent.attr("data-vendedor"));
            this.$inputVendedorName = this.$("#" + this.$inputVendedor.attr("data-name"));

            if (this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', '');
                this.$btnContact.attr('data-address-default', '');
                this.$btnContact.attr('ata-address-nomenclatura-default', '');
                this.$btnContact.attr('data-municipio-default', '');
            }

            if (this.$inputOrden.length > 0) {
                this.$inputOrden.attr('data-tercero', '');
            }

            if (this.$inputComision.length > 0) {
                this.$inputComision.val('');
            }

            var tercero = this.$inputContent.val();

            var data = {
                tercero_nit: tercero,
                tiempop_tercero: this.$inputTiempop,
                tercero_proveedor: this.$inputProveedor,
                tercero_vendedor_estado: this.checkVendedor,
                search_vendedor: this.$inputVendedor.length
            }

            // Before eval clear data
            this.$inputName.val('');

            if (!_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '') {
                // Get tercero
                $.ajax({
                    url: window.Misc.urlFull(Route.route('search.terceros')),
                    type: 'GET',
                    data: data,
                    beforeSend: function () {
                        _this.$inputName.val('');
                        window.Misc.setSpinner(_this.$wraperConten);
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner(_this.$wraperConten);
                    if (resp.success) {
                        if (!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)) {
                            _this.$inputName.val(resp.tercero_nombre);
                        }

                        if (_this.$btnContact.length > 0) {
                            _this.$btnContact.attr('data-tercero', resp.id);
                            _this.$btnContact.attr('data-address-default', resp.tercero_direccion);
                            _this.$btnContact.attr('data-address-nomenclatura-default', resp.tercero_direccion_nomenclatura);
                            _this.$btnContact.attr('data-municipio-default', resp.tercero_municipio);
                        }

                        if (_this.$inputOrden.length > 0) {
                            _this.$inputOrden.attr('data-tercero', resp.id);
                        }

                        if (_this.$inputComision.length > 0) {
                            _this.$inputComision.val(resp.tercero_comision);
                        }

                        if (_this.$inputVendedor.length > 0) {
                            _this.$inputVendedor.val(!_.isNull(resp.vendedor) ? resp.vendedor.tercero_nit : '');
                            _this.$inputVendedorName.val(!_.isNull(resp.vendedor) ? resp.vendedor.tercero_nombre : '');
                        }

                        if (_this.$inputFormapago.length > 0 || _.isNull(resp.tercero_formapago)) {
                            _this.$inputFormapago.val(resp.tercero_formapago );
                        }
                    }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner(_this.$wraperConten);
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();
        }
    });
})(jQuery, this, this.document);
