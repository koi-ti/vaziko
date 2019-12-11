/**
* Class ComponentProductView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentProductView = Backbone.View.extend({

        template: _.template(($('#producto-item-show-tpl').html() || '')),
		events: {},
        parameters: {
            modal: null
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            // Initialize
            _.bindAll(this, 'onCompleteLoadFile', 'onSessionRequestComplete');

            if (!_.isUndefined(this.parameters.modal)) {
                this.$modal = this.parameters.modal;
            }

            // // Reference title
            // this.$title = $('.title-producto-show');
            //
            // // reference collections
            // this.materialesProductopOrdenList = new app.MaterialesProductopOrdenList();
            // this.empaquesProductopOrdenList = new app.EmpaquesProductopOrdenList();
            // this.areasProductopOrdenList = new app.AreasProductopOrdenList();
            // this.transportesProductopOrdenList = new app.TransportesProductopOrdenList();

            this.listenTo( this.model, 'change', this.render );
        },

        render: function () {
            var attributes = this.model.toJSON();

            this.$el.find('.content-modal').html(this.template(attributes));

            // this.$uploaderFile = this.$('.fine-uploader');
            // this.spinner = $('.spinner-main');
            //
            // if (this.$title.length)
            //     this.$title.text(attributes.productop_nombre)
            //
            // this.uploadPictures(attributes);
            // this.referenceViews();
            // this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = this.parameters.dataFilter;

            // Materiales
            this.materialesProductopOrdenListView = new app.MaterialesProductopOrdenListView({
                collection: this.materialesProductopOrdenList,
                parameters: {
                    dataFilter: dataFilter
                }
            });

            // Empaques
            this.empaquesProductopOrdenListView = new app.EmpaquesProductopOrdenListView({
                collection: this.empaquesProductopOrdenList,
                parameters: {
                    dataFilter: dataFilter
                }
            });

            // Areas
            this.areasProductopOrdenListView = new app.AreasProductopOrdenListView({
                collection: this.areasProductopOrdenList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Transportes
            this.transportesProductopOrdenListView = new app.TransportesProductopOrdenListView({
                collection: this.transportesProductopOrdenList,
                parameters: {
                    dataFilter: dataFilter
                }
            });
        },

        /**
        * UploadPictures
        */
        uploadPictures: function(model) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-ordenp-producto',
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull(Route.route('ordenes.productos.imagenes.index')),
                    params: {
                        orden2: this.model.get('id'),
                    },
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

            this.$uploaderFile.find('.buttons').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        onSessionRequestComplete: function (id, name, resp) {
            _.each( id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
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
            var itemFile = this.$uploaderFile.fineUploader('getItemByFileId', id);
            this.$uploaderFile.fineUploader('setUuid', id, resp.id);
            this.$uploaderFile.fineUploader('setName', id, resp.name);

            var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', id).find('.preview-link');
                previewLink.attr("href", resp.url);
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
