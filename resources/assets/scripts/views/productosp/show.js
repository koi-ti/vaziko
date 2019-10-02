/**
* Class ShowProductopView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductopView = Backbone.View.extend({

        el: '#productop-show',
        events: {
            'click .clone-productop': 'cloneProductop',
        },

        /**
        * Constructor Method
        */
        initialize: function () {
            _.bindAll(this, 'onSessionRequestComplete');

            this.tipsList = new app.TipsList();
            this.areasList = new app.AreasList();
            this.maquinasList = new app.MaquinasList();
            this.materialesList = new app.MaterialesList();
            this.acabadosList = new app.AcabadosList();
            this.$uploaderFile = this.$('.fine-uploader');

            // Reference views
            this.referenceViews();
            this.fineUploader();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
       		// Tips list
            this.tipsListView = new app.TipsListView( {
                collection: this.tipsList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-tips'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Areas list
            this.areasListView = new app.AreasListView( {
                collection: this.areasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-areas'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Areas list
            this.maquinasListView = new app.MaquinasListView( {
                collection: this.maquinasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-maquinas'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Materiales list
            this.materialesListView = new app.MaterialesListView( {
                collection: this.materialesList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-materiales'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });

            // Acabados list
            this.acabadosListView = new app.AcabadosListView( {
                collection: this.acabadosList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-acabados'),
                    dataFilter: {
                        productop_id: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Events FineUploader
        */
        fineUploader: function(e) {
            var _this = this;

            this.$uploaderFile.fineUploader({
                debug: false,
                template: 'qq-template-producto',
                dragDrop: false,
                session: {
                    endpoint: window.Misc.urlFull(Route.route('productosp.imagenes.index')),
                    params: {
                        productop: _this.model.get('id')
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
                    onSessionRequestComplete: _this.onSessionRequestComplete,
                }
            });

            this.$uploaderFile.find('.buttons').remove();
            this.$uploaderFile.find('.qq-upload-drop-area').remove();
        },

        /**
        * onSessionRequestComplete
        */
        onSessionRequestComplete: function (id, name, resp) {
            _.each(id, function (value, key){
                var previewLink = this.$uploaderFile.fineUploader('getItemByFileId', key).find('.preview-link');
                    previewLink.attr("href", value.thumbnailUrl);
            }, this);
        },

        cloneProductop: function (e) {
            e.preventDefault();

            var route = window.Misc.urlFull(Route.route('productosp.clonar', {productosp: this.model.get('id')})),
                _this = this;

            // Clone producto
            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template(($('#productop-clone-confirm-tpl').html() || '')),
                    titleConfirm: 'Clonar producto',
                    onConfirm: function () {
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function (resp) {
                                    window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('productosp.show', {productosp: resp.id})));
                                }
                            })(_this)
                        });
                    }
                }
            });
            cloneConfirm.render();
        }
    });

})(jQuery, this, this.document);
