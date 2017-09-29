/**
* Class MainPlanCuentasNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.MainPlanCuentasNifView = Backbone.View.extend({

        el: '#plancuentasnif-main',
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
            this.$plancuentasNifSearchTable = this.$('#plancuentasnif-search-table');
            this.$searchCuenta = this.$('#plancuentasn_cuenta');
            this.$searchName = this.$('#plancuentasn_nombre');

            this.plancuentasNifSearchTable = this.$plancuentasNifSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('plancuentasnif.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.plancuentasn_cuenta = _this.$searchCuenta.val();
                        data.plancuentasn_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentasn_cuenta', name: 'plancuentasn_cuenta' },
                    { data: 'plancuentasn_nivel', name: 'plancuentasn_nivel' },
                    { data: 'plancuentasn_nombre', name: 'plancuentasn_nombre' },
                    { data: 'plancuentasn_naturaleza', name: 'plancuentasn_naturaleza' },
                    { data: 'plancuentasn_tercero', name: 'plancuentasn_tercero' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('plancuentasnif.show', { plancuentasnif: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '10%'
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.plancuentasNifSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCuenta.val('');
            this.$searchName.val('');

            this.plancuentasNifSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);
