/**
* Class MainFacturasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturasView = Backbone.View.extend({

        el: '#facturas-main',
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
            this.$facturasSearchTable = this.$('#facturas-search-table');
            var paginacion = this.$facturasSearchTable.data('pagination');

            // References
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');

            this.facturasSearchTable = this.$facturasSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull(Route.route('facturas.index')),
                    data: function (data) {
                        data.persistent = true;
                        data.factura1_numero = _this.$searchfacturaNumero.val();
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                        data.tercero_nombre = _this.$searchfacturaTerceroNombre.val();
                    }
                },
                columns: [
                    { data: 'factura1_numero', name: 'factura1_numero' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'factura1_tercero' },
                    { data: 'factura1_total', name: 'factura1_total' },
                    { data: 'factura1_anulado', name: 'factura1_anulado' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function (data, type, full, row) {
                           return '<a href="'+ window.Misc.urlFull(Route.route('facturas.show', {facturas: full.id }))  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: 1,
                        width: '5%'
                    },
                    {
                        targets: 2,
                        width: '15%'
                    },
                    {
                        targets: 4,
                        width: '10%',
                        className: 'text-right',
                        render: function (data, type, full, row) {
                            return window.Misc.currency(data);
                        },
                    },
                    {
                        targets: 5,
                        width: '10%',
                        render: function (data, type, full, row) {
                            return parseInt(data) ? 'ANULADO' : 'ABIERTA';
                        },
                    },
                ],
                fnRowCallback: function(row, data) {
                    if (parseInt(data.factura1_anulado)) {
                        $(row).css({"color":"red"});
                    } else {
                        $(row).css({"color":"#00a65a"});
                    }
                }
            });
        },

        search: function(e) {
            e.preventDefault();

            this.facturasSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchfacturaNumero.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturasSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
