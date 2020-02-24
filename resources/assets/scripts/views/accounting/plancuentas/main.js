/**
* Class MainPlanCuentasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.MainPlanCuentasView = Backbone.View.extend({

        el: '#plancuentas-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            var _this = this;

            // Rerefences
            this.$plancuentasSearchTable = this.$('#plancuentas-search-table');
            this.$searchCuenta = this.$('#plancuentas_cuenta');
            this.$searchName = this.$('#plancuentas_nombre');

            this.plancuentasSearchTable = this.$plancuentasSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: {
                    url: window.Misc.urlFull(Route.route('plancuentas.index')),
                    data: function (data) {
                        data.persistent = true;
                        data.plancuentas_cuenta = _this.$searchCuenta.val();
                        data.plancuentas_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentas_cuenta', name: 'plancuentas_cuenta' },
                    { data: 'plancuentas_nivel', name: 'plancuentas_nivel' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'plancuentas_naturaleza', name: 'plancuentas_naturaleza' },
                    { data: 'plancuentas_tercero', name: 'plancuentas_tercero' },
                    { data: 'plancuentas_equivalente', name: 'plancuentas_equivalente' },
                    { data: 'plancuentas_tipo', name: 'plancuentas_tipo' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '13%',
                        render: function (data, type, full, row) {
                            return '<a href="'+ window.Misc.urlFull(Route.route('plancuentas.show', {plancuentas: full.id}))  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '5%'
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return data == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 5,
                        width: '15%',
                        render: function (data, type, full, row) {
                            if (!_.isNull( full.plancuentas_equivalente ) && !_.isUndefined( full.plancuentas_equivalente)) {
                                return '<a href="'+ window.Misc.urlFull(Route.route('plancuentasnif.show', {plancuentasnif: full.plancuentas_equivalente })) +'">' + full.plancuentasn_cuenta + '</a>';
                            }
                            return '';
                        }
                    },
                    {
                        targets: 6,
                        width: '15%',
                        render: function (data, type, full, row) {
                            if (data == 'N') {
                                return 'Ninguno';
                            } else if (data == 'I') {
                                return 'Inventario';
                            } else if (data == 'C') {
                                return 'Cartera';
                            } else if (data == 'P') {
                                return 'Cuentas por pagar';
                            }
                            return '';
                        }
                    }
                ]
			});
        },

        search: function (e) {
            e.preventDefault();

            this.plancuentasSearchTable.ajax.reload();
        },

        clear: function (e) {
            e.preventDefault();

            this.$searchCuenta.val('');
            this.$searchName.val('');

            this.plancuentasSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
