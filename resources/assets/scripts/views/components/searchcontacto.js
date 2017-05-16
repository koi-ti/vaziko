/**
* Class ComponentSearchContactoView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchContactoView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-contacto-component-tpl').html() || '') ),

		events: {
            'click .btn-koi-search-contacto-component-table': 'searchOrden',
            'click .btn-search-koi-search-contacto-component': 'search',
            'click .btn-clear-koi-search-contacto-component': 'clear',
            'click .a-koi-search-contacto-component-table': 'setContacto'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-contacto-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchContactoNombres = this.$('#koi_search_contacto_nombres');
            this.$searchContactoApellidos = this.$('#koi_search_contacto_apellidos');

            // Validate tercero
			this.$resourceTercero = this.$("#"+$(e.currentTarget).attr("data-tercero"));
			var tercero = this.$resourceTercero.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar contacto.');
                return;
            }

            this.$contactoSearchTable = this.$modalComponent.find('#koi-search-contacto-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
            this.$inputPhone = this.$("#"+$(e.currentTarget).attr("data-phone"));
            this.$inputAddress = this.$("#"+$(e.currentTarget).attr("data-address"));
            this.$inputNomenclatura = this.$("#"+$(e.currentTarget).attr("data-nomenclatura"));
            this.$labelNomenclatura = this.$("#"+$(e.currentTarget).attr("data-name-nomenclatura"));
            this.$inputCity = this.$("#"+$(e.currentTarget).attr("data-city"));
			this.$inputEmail = this.$("#"+$(e.currentTarget).attr("data-email"));

			this.contactoSearchTable = this.$contactoSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('terceros.contactos.index') ),
                    data: function( data ) {
                        data.tcontacto_nombres = _this.$searchContactoNombres.val(),
                        data.tcontacto_apellidos = _this.$searchContactoApellidos.val(),
                        data.tcontacto_tercero = tercero
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tcontacto_nombres', name: 'tcontacto_nombres' },
                    { data: 'tcontacto_apellidos', name: 'tcontacto_apellidos' },
                    { data: 'tcontacto_nombre', name: 'tcontacto_nombre' },
                    { data: 'tcontacto_telefono', name: 'tcontacto_telefono' },
                    { data: 'municipio_nombre', name: 'municipio_nombre' },
                    { data: 'tcontacto_direccion', name: 'tcontacto_direccion' },
                    { data: 'tcontacto_municipio', name: 'tcontacto_municipio' },
                    { data: 'tcontacto_email', name: 'tcontacto_email' }
                ],
                columnDefs: [
                    {
                        targets: 3,
                        width: '40%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-contacto-component-table">' + data + '</a>';
                        }
                    },
                	{
                        targets: [0,1,2,7,8],
                        visible: false
                    }
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setContacto: function(e) {
			e.preventDefault();

	        var data = this.contactoSearchTable.row( $(e.currentTarget).parents('tr') ).data();
			this.$inputContent.val( data.id );
			this.$inputName.val( data.tcontacto_nombre );
			if(this.$inputPhone.length) {
                this.$inputPhone.val( data.tcontacto_telefono );
            }
            if(this.$inputAddress.length) {
                this.$inputAddress.val( data.tcontacto_direccion );
            }
            if(this.$inputNomenclatura.length) {
                this.$inputNomenclatura.val( data.tcontacto_direccion_nomenclatura );
            }
            if(this.$labelNomenclatura.length) {
                this.$labelNomenclatura.text( data.tcontacto_direccion_nomenclatura );
            }
            if(this.$inputCity.length) {
                this.$inputCity.val( data.tcontacto_municipio ).trigger('change');
            }
            if(this.$inputEmail.length) {
				this.$inputEmail.val( data.tcontacto_email );
			}

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.contactoSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchContactoNombres.val('');
            this.$searchContactoApellidos.val('');

            this.contactoSearchTable.ajax.reload();
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
