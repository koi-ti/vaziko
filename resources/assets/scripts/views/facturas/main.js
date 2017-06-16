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
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$facturasSearchTable = this.$('#facturas-search-table');

            // References
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaOrdenp = this.$('#searchfactura_ordenp');
            this.$searchfacturaOrdenpBeneficiario = this.$('#searchfactura_ordenp_beneficiario');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');
            
            this.facturasSearchTable = this.$facturasSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturas.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.id = _this.$searchfacturaNumero.val();
                        data.orden_codigo = _this.$searchfacturaOrdenp.val();
                        data.orden_tercero = _this.$searchfacturaOrdenpBeneficiario.val();
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                        data.tercero_nombre = _this.$searchfacturaTerceroNombre.val();
                    }
                },
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'factura1_tercero' },
                    { data: 'orden_beneficiario', name: 'orden_beneficiario' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturas.show', {facturas: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                ]
            });
        },

        search: function(e) {
            e.preventDefault();

            this.facturasSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchfacturaNumero.val('');
            this.$searchfacturaOrdenp.val('');
            this.$searchfacturaOrdenpBeneficiario.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturasSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);
