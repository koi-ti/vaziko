/**
* Class ComponentSearchProductopView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductopView = Backbone.View.extend({

      	el: 'body',
        template: _.template(($('#koi-search-productop-component-tpl').html() || '')),
		events: {
            'click .btn-koi-search-productop-component-table': 'searchProducto',
            'click .btn-search-koi-search-productop-component': 'search',
            'click .btn-clear-koi-search-productop-component': 'clear',
            'click .a-koi-search-productop-component-table': 'setProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function () {
			// Initialize
            this.$modalComponent = this.$('#modal-search-productop-component');
		},

		searchProducto: function (e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html(this.template({}));

            // References
            this.$searchCodigo = this.$('#koi_search_productop_codigo');
            this.$searchNombre = this.$('#koi_search_productop_nombre');

            this.$productospSearchTable = this.$modalComponent.find('#koi-search-productop-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            var productop = this.$inputContent.attr("data-productop");

			this.productospSearchTable = this.$productospSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull(Route.route('search.productosp')),
                    data: function (data) {
                        data.search = true;
                        data.id = _this.$searchCodigo.val();
                        data.productop_nombre = _this.$searchNombre.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'productop_nombre', name: 'productop_nombre' }
                ],
                columnDefs: [
					{
                        width: '10%',
						targets: 0,
						render: function (data, type, full, row) {
							return '<a href="#" class="a-koi-search-productop-component-table">' + data + '</a>';
						}
					}
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function (e) {
			e.preventDefault();

	        var data = this.productospSearchTable.row($(e.currentTarget).parents('tr')).data(),
                productop = this.$inputContent.attr("data-productop");

            if (productop == 'true') {
                this.$inputContent.html('').append("<option value='" + data.id + "' selected>" + data.productop_nombre + "</option>").removeAttr('disabled');
            } else {
                this.$inputContent.val(data.id);
                this.$inputName.val(data.productop_nombre);
            }

			this.$modalComponent.modal('hide');
		},

		search: function (e) {
			e.preventDefault();

		    this.productospSearchTable.ajax.reload();
		},

		clear: function (e) {
			e.preventDefault();

            this.$searchCodigo.val('');
            this.$searchNombre.val('');

            this.productospSearchTable.ajax.reload();
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
