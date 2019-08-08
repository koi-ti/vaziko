/**
* Class MainFacturaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturaspView = Backbone.View.extend({

        el: '#facturasp-main',
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
            this.$facturaspSearchTable = this.$('#facturasp-search-table');
            var paginacion = this.$facturaspSearchTable.data('paginacion');

            // References
            this.$searchfacturapFacturap = this.$('#searchfacturap_facturap');
            this.$searchfacturapFecha = this.$('#searchfacturap_fecha');
            this.$searchfacturapTercero = this.$('#searchfacturap_tercero');
            this.$searchfacturapTerceroNombre = this.$('#searchfacturap_tercero_nombre');

            this.facturaspSearchTable = this.$facturaspSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                pageLength: paginacion,
                ajax: {
                    url: window.Misc.urlFull(Route.route('facturap.index')),
                    data: function(data) {
                        data.persistent = true;
                        data.facturap = _this.$searchfacturapFacturap.val();
                        data.facturap_fecha = _this.$searchfacturapFecha.val();
                        data.tercero_nit = _this.$searchfacturapTercero.val();
                        data.tercero_nombre = _this.$searchfacturapTerceroNombre.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'facturap1_factura', name: 'facturap1_factura' },
                    { data: 'facturap1_fecha', name: 'facturap1_fecha' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function (data, type, full, row) {
                           return '<a href="'+ window.Misc.urlFull(Route.route('facturap.show', {facturap: full.id}))  +'">' + data + '</a>';
                        },
                    },
                ]
            });
        },

        search: function (e) {
            e.preventDefault();

            this.facturaspSearchTable.ajax.reload();
        },

        clear: function (e) {
            e.preventDefault();

            this.$searchfacturapFacturap.val('');
            this.$searchfacturapFecha.val('');
            this.$searchfacturapTercero.val('');
            this.$searchfacturapTerceroNombre.val('');

            this.facturaspSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
