/**
* Class EditTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditTerceroView = Backbone.View.extend({

        el: '#tercero-create',
        template: _.template( ($('#add-tercero-tpl').html() || '') ),
        events: {
            'submit #form-tercero': 'onStore',
            'submit #form-item-roles': 'onStoreRol',
            'submit #form-changed-password': 'onStorePassword',
            'ifChanged .change_employee': 'changedEmployee',
            'ifChanged #tercero_tecnico': 'changedTechnical',
            'ifChanged #tercero_coordinador': 'changedCoordinador',
            'click .btn-add-tcontacto': 'addContacto'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.msgSuccess = 'Tercero guardado con exito!';

            this.contactsList = new app.ContactsList();
            this.rolList = new app.RolList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = true;

            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-tercero');
            this.$formAccounting = this.$('#form-accounting');
            this.$formEmployee = this.$('#form-employee');

            this.$checkEmployee = this.$('#tercero_empleado');
            this.$checkInternal = this.$('#tercero_interno');

            this.$coordinador_por = this.$('#tercero_coordinador_por');

            this.$username = this.$('#username');
            this.$password = this.$('#password');
            this.$password_confirmation = this.$('#password_confirmation');

            this.$wrapperEmployes = this.$('#wrapper-empleados');
            this.$wrapperCoordinador = this.$('#wrapper-coordinador');

            this.$uploaderFile = this.$('.fine-uploader');
            this.spinner = this.$('.spinner-main');

            // Reference views
            this.referenceViews();
            this.uploadPictures();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-tcontacto'),
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), window.Misc.formToJson( this.$formAccounting ), window.Misc.formToJson( this.$formEmployee ));
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item rol
        */
        onStoreRol: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.rolList.trigger( 'store', data );
            }
        },

        addContacto: function() {
            this.contactsListView.trigger('createOne',
                this.model.get('id'),
                this.model.get('tercero_direccion'),
                this.model.get('tercero_dir_nomenclatura'),
                this.model.get('tercero_municipio')
            );
        },

        changedTechnical: function(e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$wrapperCoordinador.removeClass('hide');
            }else{
                this.$wrapperCoordinador.addClass('hide');
            }
        },

        changedCoordinador: function(e){
            var selected = $(e.target).is(':checked');
            var nombre = this.model.get('tercero_nombre1')+' '+this.model.get('tercero_nombre2')+' '+this.model.get('tercero_apellido1')+' '+this.model.get('tercero_apellido2');
            var select = [{id: this.model.get('id') , text: nombre}];

            if( selected ) {
                this.$coordinador_por.select2({ data: select }).trigger('change');
                this.$coordinador_por.select2({ language: 'es', placeholder: 'Seleccione', allowClear: false });
            }else{
                this.$coordinador_por.find('option[value='+this.model.get('id')+']').remove();
            }
        },

        changedEmployee: function(e) {
            // Active if internal or employee
            if( this.$checkInternal.is(':checked') || this.$checkEmployee.is(':checked') ) {
                this.$wrapperEmployes.removeClass('hide')
            }else{
                this.$wrapperEmployes.addClass('hide')
            }
        },

        onStorePassword: function(e) {
            var _this = this;

            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.id = this.model.get('id');

                $.ajax({
                    type: "POST",
                    url: window.Misc.urlFull( Route.route('terceros.setpassword') ),
                    data: data,
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$('#wrapper-password') );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$('#wrapper-password') );
                    if(!_.isUndefined(resp.success)) {
                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        alertify.success(resp.message);
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$('#wrapper-password') );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template',
                multiple: true,
                autoUpload: true,
                session: {
                    endpoint: window.Misc.urlFull( Route.route('terceros.imagenes.index') ),
                    params: {
                        tercero_id: this.model.get('id'),
                    },
                    refreshOnRequest: false
                },
                request: {
                    inputName: 'file',
                    endpoint: window.Misc.urlFull( Route.route('terceros.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tercero_id: this.model.get('id')
                    }
                },
                retry: {
                    maxAutoAttempts: 3,
                },
                deleteFile: {
                    enabled: true,
                    forceConfirm: true,
                    confirmMessage: '¿Esta seguro de que desea eliminar este archivo de forma permanente? {filename}',
                    endpoint: window.Misc.urlFull( Route.route('terceros.imagenes.index') ),
                    params: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tercero_id: this.model.get('id')
                    }
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                validation: {
                    itemLimit: 10,
                    sizeLimit: ( 3 * 1024 ) * 1024, // 3mb,
                    allowedExtensions: ['jpeg', 'jpg', 'png', 'pdf']
                },
                messages: {
                    typeError: '{file} extensión no valida. Extensiones validas: {extensions}.',
                    sizeError: '{file} es demasiado grande, el tamaño máximo del archivo es {sizeLimit}.',
                    tooManyItemsError: 'No puede seleccionar mas de {itemLimit} archivos.',
                },
                callbacks: {
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                },
            });
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            this.$uploaderFile.find('.btn-imprimir').remove();

            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);

            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
            previewLink.attr("href", resp.url);
        },

        onSessionRequestComplete: function (id, name, resp) {
            this.$uploaderFile.find('.btn-imprimir').remove();

            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                previewLink.attr("href", value.thumbnailUrl);
            }, this);
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                alertify.success(this.msgSuccess);

                // Redirect to edit tercero
                window.Misc.redirect( window.Misc.urlFull( Route.route('terceros.index') ) );
            }
        }
    });

})(jQuery, this, this.document);
