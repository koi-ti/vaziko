/**
* Class ComponentCreateResourceView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentCreateResourceView = Backbone.View.extend({

      	el: 'body',
		events: {
            'click .btn-add-resource-koi-component': 'addResource',
            'submit #form-create-resource-component': 'onStore'
		},
        parameters: {
        },

        /**
        * Constructor Method
        */
		initialize: function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

			// Initialize
            this.$modalComponent = this.$('#modal-add-resource-component');
            this.$wraperError = this.$('#error-resource-component');
            this.$wraperContent = this.$('#content-create-resource-component').find('.modal-body');
		},

		/**
        * Display form modal resource
        */
		addResource: function(e) {
            // References
            this.resource = $(e.currentTarget).attr("data-resource");
            this.$resourceField = $("#"+$(e.currentTarget).attr("data-field"));
            this.parameters = {};

            if(this.resource == 'contacto') {
                var address = null, nomenclatura = null, municipio = null;
                this.$inputPhone = this.$("#"+$(e.currentTarget).attr("data-phone"));
                this.$inputAddress = this.$("#"+$(e.currentTarget).attr("data-address"));
                this.$inputCity = this.$("#"+$(e.currentTarget).attr("data-city"));
                this.$inputEmail = this.$("#"+$(e.currentTarget).attr("data-email"));
                this.parameters.tcontacto_tercero = $(e.currentTarget).attr("data-tercero");
                if( _.isUndefined(this.parameters.tcontacto_tercero) || _.isNull(this.parameters.tcontacto_tercero) || this.parameters.tcontacto_tercero == '') {
                    alertify.error('Por favor ingrese cliente antes agregar contacto.');
                    return;
                }

                // Get default values form
                address = $(e.currentTarget).attr("data-address-default");
                nomenclatura = $(e.currentTarget).attr("data-address-nomenclatura-default");
                municipio = $(e.currentTarget).attr("data-municipio-default");
            }

            // stuffToDo resource
            var _this = this,
	            stuffToDo = {
	                'centrocosto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Centros de costo');

    	            	_this.model = new app.CentroCostoModel();
                        var template = _.template($('#add-centrocosto-tpl').html());
            			_this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
    	            },
                    'folder' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Folder');

                        _this.model = new app.FolderModel();
                        var template = _.template($('#add-folder-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'tercero' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Tercero');

                        _this.model = new app.TerceroModel();
                        var template = _.template($('#add-generic-tercero-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );

                        _this.$formAccounting = _this.$modalComponent.find('#form-accounting');
                    },
                    'grupo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Grupo inventario');

                        _this.model = new app.GrupoModel();
                        var template = _.template($('#add-grupo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'subgrupo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Subrupo inventario');

                        _this.model = new app.SubGrupoModel();
                        var template = _.template($('#add-subgrupo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'unidadmedida' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Unidad de medida');

                        _this.model = new app.UnidadModel();
                        var template = _.template($('#add-unidad-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'producto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Producto');

                        _this.model = new app.ProductoModel();
                        var template = _.template($('#add-producto-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'contacto' : function() {
                        _this.$resourceName = $("#"+$(e.currentTarget).attr("data-name"));
                        _this.$modalComponent.find('.inner-title-modal').html('Contacto');

                        _this.model = new app.ContactoModel({
                            tcontacto_direccion: address,
                            tcontacto_direccion_nomenclatura: nomenclatura,
                            tcontacto_municipio: municipio
                        });
                        var template = _.template($('#add-contacto-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'areap' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Área de producción');

                        _this.model = new app.AreapModel();
                        var template = _.template($('#add-areap-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'maquinap' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Máquina de producción');

                        _this.model = new app.MaquinapModel();
                        var template = _.template($('#add-maquinap-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'materialp' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Material de producción');

                        _this.model = new app.MaterialpModel();
                        var template = _.template($('#add-materialp-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'acabadop' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Acabado de producción');

                        _this.model = new app.AcabadopModel();
                        var template = _.template($('#add-acabadop-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
	            };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                this.$wraperError.hide().empty();

	            // Events
            	this.listenTo( this.model, 'sync', this.responseServer );
            	this.listenTo( this.model, 'request', this.loadSpinner );

                // to fire plugins
                this.ready();

				this.$modalComponent.modal('show');
            }
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

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        /**
        * Event Create Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                this.$wraperError.hide().empty();

                e.preventDefault();
                var data = $.extend({}, this.parameters, window.Misc.formToJson( e.target ));

                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

            // response success or error
            var text = resp.success ? '' : resp.errors;
            if( _.isObject( resp.errors ) ) {
                text = window.Misc.parseErrors(resp.errors);
            }

            if( !resp.success ) {
                this.$wraperError.empty().append(text);
                this.$wraperError.show();
                return;
            }

            // stuffToDo Response success
            var _this = this,
                stuffToDo = {
                    'centrocosto' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('centrocosto_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'folder' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('folder_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'tercero' : function() {
                        _this.$resourceField.val(_this.model.get('tercero_nit')).trigger('change');
                    },
                    'grupo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('grupo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'subgrupo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('subgrupo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'unidadmedida' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('unidadmedida_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'producto' : function() {
                        _this.$resourceField.val(_this.model.get('producto_codigo')).trigger('change');
                    },
                    'contacto' : function() {
                        _this.$resourceField.val(_this.model.get('id'));
                        _this.$resourceName.val(_this.model.get('tcontacto_nombre'));

                        if(_this.$inputPhone.length) {
                            _this.$inputPhone.val( _this.model.get('tcontacto_telefono') );
                        }

                        if(_this.$inputAddress.length) {
                            _this.$inputAddress.val( _this.model.get('tcontacto_direccion') );
                        }

                        if(_this.$inputEmail.length) {
                            _this.$inputEmail.val( _this.model.get('tcontacto_email') );
                        }

                        if(_this.$inputCity.length) {
                            _this.$inputCity.val( _this.model.get('tcontacto_municipio') ).trigger('change');
                        }
                    },
                    'areap' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('areap_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'maquinap' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('maquinap_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'materialp' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('materialp_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'acabadop' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('acabadop_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                // Fires libraries js
                if( typeof window.initComponent.initSelect2 == 'function' )
                    window.initComponent.initSelect2();

                this.$modalComponent.modal('hide');
            }
        }
    });


})(jQuery, this, this.document);
