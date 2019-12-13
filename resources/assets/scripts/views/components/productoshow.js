/**
* Class ComponentProductView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentProductView = Backbone.View.extend({

        template: _.template(($('#add-producto-component-tpl').html() || '')),
        templateMaquinas: _.template(($('#add-producto-component-maquinas-item-tpl').html() || '')),
        templateAcabados: _.template(($('#add-producto-component-acabados-item-tpl').html() || '')),
        templateMateriales: _.template(($('#add-producto-component-materiales-item-tpl').html() || '')),
        templateAreas: _.template(($('#add-producto-component-areas-item-tpl').html() || '')),
        templateEmpaques: _.template(($('#add-producto-component-empaques-item-tpl').html() || '')),
        templateTransportes: _.template(($('#add-producto-component-transportes-item-tpl').html() || '')),
        parameters: {
            modal: null,
            collections: {},
            dataFilter: {},
            fineUploader: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Initialize
            this.$modal = this.parameters.modal;

            // If not exists modal
            this.$title = $('.title-producto-show');

            // Instance collections
            this.maquinasComponentProductoList = this.parameters.collections.maquinas;
            this.acabadosComponentProductoList = this.parameters.collections.acabados;
            this.materialesComponentProductoList = this.parameters.collections.materiales;
            this.areasComponentProductoList = this.parameters.collections.areas;
            this.empaquesComponentProductoList = this.parameters.collections.empaques;
            this.transportesComponentProductoList = this.parameters.collections.tranportes;

            // Listen to collections changes
            this.listenTo( this.maquinasComponentProductoList, 'reset', this.addAllMaquinas );
            this.listenTo( this.acabadosComponentProductoList, 'reset', this.addAllAcabados );
            this.listenTo( this.materialesComponentProductoList, 'reset', this.addAllMateriales );
            this.listenTo( this.areasComponentProductoList, 'reset', this.addAllAreas );
            this.listenTo( this.empaquesComponentProductoList, 'reset', this.addAllEmpaques );
            this.listenTo( this.transportesComponentProductoList, 'reset', this.addAllTransportes );

            // Blind functions
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            // Listen to render model
            this.listenTo( this.model, 'change', this.render );
        },

        /**
        * Render attributes
        */
        render: function () {
            var attributes = this.convertAttributes(this.model.toJSON(), /(precotizacion2|cotizacion2|orden2)/gi, 'producto');

            // Find template content
            if (this.parameters.modal) {
                this.$el.find('.content-modal').html(this.template(attributes));
                this.$el.find('.modal-title').text(attributes.productop_nombre);
            } else {
                this.$el.html(this.template(attributes));
                this.$title.text(attributes.productop_nombre);
            }

            // Find wrapper of collections
            this.$wrapperMaquinas = this.$('#browse-component-producto-maquinas-list').find('tbody');
            this.$wrapperAcabados = this.$('#browse-component-producto-acabados-list').find('tbody');
            this.$wrapperMateriales = this.$('#browse-component-producto-materiales-list').find('tbody');
            this.$wrapperAreas = this.$('#browse-component-producto-areas-list').find('tbody');
            this.$wrapperEmpaques = this.$('#browse-component-producto-empaques-list').find('tbody');
            this.$wrapperTransportes = this.$('#browse-component-producto-transportes-list').find('tbody');

            // Reference fineUploader
            this.$fineUploader = this.$('.fine-uploader');

            // Fetch collections & fire libraries
            this.referenceFineUploader();
            this.referenceViews();
            this.ready();
        },

        convertAttributes: function (model, find, replace) {
            var object = {},
                _this;

            _.each(model, function (value, key) {
                var name = {};
                name[key.toString().replace(find, replace)] = value;
                Object.assign(object, name);
            });
            return object;
        },

        /**
        * referenceFineUploader
        */
        referenceFineUploader: function (model) {
            var _this = this;

            this.$fineUploader.fineUploader({
                debug: false,
                template: 'qq-template-component-producto',
                dragDrop: false,
                session: {
                    endpoint: _this.parameters.fineUploader.endpoint,
                    params: _this.parameters.fineUploader.params,
                    refreshOnRequest: false
                },
                thumbnails: {
                    placeholders: {
                        notAvailablePath: window.Misc.urlFull("build/css/placeholders/not_available-generic.png"),
                        waitingPath: window.Misc.urlFull("build/css/placeholders/waiting-generic.png")
                    }
                },
                callbacks: {
                    onComplete: _this.onCompleteLoadFile,
                    onSessionRequestComplete: this.onSessionRequestComplete
                }
            });

            this.$fineUploader.find('.buttons').remove();
            this.$fineUploader.find('.qq-upload-drop-area').remove();
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onSessionRequestComplete: function (id, name, resp) {
            _.each(id, function (value, key) {
                var previewLink = this.$fineUploader.fineUploader('getItemByFileId', key).find('.preview-link');
                    previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        /**
        * complete upload of file
        * @param Number id
        * @param Strinf name
        * @param Object resp
        */
        onCompleteLoadFile: function (id, name, resp) {
            var itemFile = this.$fineUploader.fineUploader('getItemByFileId', id);
            this.$fineUploader.fineUploader('setUuid', id, resp.id);
            this.$fineUploader.fineUploader('setName', id, resp.name);

            var previewLink = this.$fineUploader.fineUploader('getItemByFileId', id).find('.preview-link');
                previewLink.attr("href", resp.url);
        },

        /**
        * Fetch collections
        */
        referenceViews: function () {
            // Fetch collections
            this.maquinasComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
            this.acabadosComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
            this.materialesComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
            this.areasComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
            this.empaquesComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
            this.transportesComponentProductoList.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * append item of collection maquina
        */
        addOneMaquina: function (model) {
            this.$wrapperMaquinas.append(this.templateMaquinas(model.toJSON()));
        },

        /**
        * Get all items of collection maquinas
        */
        addAllMaquinas: function () {
            if (this.maquinasComponentProductoList.length)
                this.$wrapperMaquinas.empty();
            this.maquinasComponentProductoList.forEach(this.addOneMaquina, this);
        },

        /**
        * append item of collection acabado
        */
        addOneAcabado: function (model) {
            this.$wrapperAcabados.append(this.templateAcabados(model.toJSON()));
        },

        /**
        * Get all items of collection acabados
        */
        addAllAcabados: function () {
            if (this.acabadosComponentProductoList.length)
                this.$wrapperAcabados.empty();
            this.acabadosComponentProductoList.forEach(this.addOneAcabado, this);
        },

        /**
        * append item of collection material
        */
        addOneMaterial: function (model) {
            var attributes = this.convertAttributes(model.toJSON(), /(precotizacion3|cotizacion4|orden4)/gi, 'material');
            this.$wrapperMateriales.append(this.templateMateriales(attributes));
        },

        /**
        * Get all items of collection materiales
        */
        addAllMateriales: function () {
            if (this.materialesComponentProductoList.length)
                this.$wrapperMateriales.empty();
            this.materialesComponentProductoList.forEach(this.addOneMaterial, this);
        },

        /**
        * append item of collection area
        */
        addOneArea: function (model) {
            var attributes = this.convertAttributes(model.toJSON(), /(precotizacion6|cotizacion6|orden6)/gi, 'area');
            this.$wrapperAreas.append(this.templateAreas(attributes));
        },

        /**
        * Get all items of collection areas
        */
        addAllAreas: function () {
            if (this.areasComponentProductoList.length)
                this.$wrapperAreas.empty();
            this.areasComponentProductoList.forEach(this.addOneArea, this);
        },

        /**
        * append item of collection empaque
        */
        addOneEmpaque: function (model) {
            var attributes = this.convertAttributes(model.toJSON(), /(precotizacion9|cotizacion9|orden9)/gi, 'empaque');
            this.$wrapperEmpaques.append(this.templateEmpaques(attributes));
        },

        /**
        * Get all items of collection empaques
        */
        addAllEmpaques: function () {
            if (this.empaquesComponentProductoList.length)
                this.$wrapperEmpaques.empty();
            this.empaquesComponentProductoList.forEach(this.addOneEmpaque, this);
        },

        /**
        * append item of collection transporte
        */
        addOneTransporte: function (model) {
            var attributes = this.convertAttributes(model.toJSON(), /(precotizacion10|cotizacion10|orden10)/gi, 'transporte');
            this.$wrapperTransportes.append(this.templateTransportes(attributes));
        },

        /**
        * Get all items of collection transportes
        */
        addAllTransportes: function () {
            if (this.transportesComponentProductoList.length)
                this.$wrapperTransportes.empty();
            this.transportesComponentProductoList.forEach(this.addOneTransporte, this);
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if (typeof window.initComponent.initICheck == 'function')
                window.initComponent.initICheck();
        },
    });

})(jQuery, this, this.document);
