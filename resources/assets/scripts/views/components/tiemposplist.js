/**
* Class TiempopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopListView = Backbone.View.extend({

        el: '#browse-tiemposp-global-list',
        events: {
            'click .item-edit': 'editOne',
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Init Attributes
            this.$modal = $('#modal-tiempop-edit-component');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            // Validar si se viene dataFilter
            if (this.parameters.dataFilter.call == 'ordenp') {
                this.viewWithDataTable();
            } else {
                this.collection.fetch({data: this.parameters.dataFilter, reset: true});
            }
        },

        viewWithDataTable: function () {
            var _this = this;

            // DataTable
            this.$searchTable = this.$el;
            this.searchTable = this.$searchTable.DataTable({
				dom: "<'row'<'col-sm-4'><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                ajax: {
                    url: window.Misc.urlFull(Route.route('tiemposp.index')),
                    data: function (data) {
                        data.call = 'ordenp';
                        data.ordenp = _this.parameters.dataFilter.orden2_orden;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'koi_tercero.tercero_nombre1' },
                    { data: 'tercero_nombre', name: 'koi_tercero.tercero_nombre2' },
                    { data: 'tercero_nombre', name: 'koi_tercero.tercero_apellido1' },
                    { data: 'tercero_nombre', name: 'koi_tercero.tercero_apellido2' },
                    { data: 'tercero_nombre', name: 'koi_tercero.tercero_nombre' },
                    { data: 'actividadp_nombre', name: 'koi_actividadp.actividadp_nombre' },
                    { data: 'subactividadp_nombre', name: 'koi_subactividadp.subactividadp_nombre' },
                    { data: 'areap_nombre', name: 'koi_areap.areap_nombre' },
                    { data: 'tiempop_fecha', name: 'tiempop_fecha' },
                    { data: 'tiempop_hora_inicio', name: 'tiempop_hora_inicio' },
                    { data: 'tiempop_hora_fin', name: 'tiempop_hora_fin' },
                    { data: 'id', name: 'id' }
                ],
                columnDefs: [
                    {
                        targets: [1, 2, 3, 4],
                        visible: false
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false
                    },
                    {
                        targets: 12,
                        className: 'text-right',
                        render: function (data, type, full, row) {
                            if (_this.parameters.edit) {
                                return '<a class="btn btn-default btn-xs item-edit" data-resource="' + data + '">' + '<span><i class="fa fa-pencil-square-o"></i></span></a>';
                            } else {
                                return '-';
                            }
                        }
                    },
                ]
			});
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopItemView({
                model: tiempopModel,
                parameters: {
                    call: this.parameters.dataFilter.call
                }
            });
            tiempopModel.view = view;
            this.$el.append(view.render().el.children)
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            if (this.collection.length)
                this.$el.find('tbody').html('');
            this.collection.forEach(this.addOne, this);
        },

        /**
        * store
        * @param form element
        */
        storeOne: function (data, form) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner(this.parameters.wrapper);

            // Add model in collection
            var tiempopModel = new app.TiempopModel();
                tiempopModel.save(data, {
                    wait: true,
                    success: function (model, resp) {
                        if (!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner(_this.parameters.wrapper);
                            var text = resp.success ? '' : resp.errors;
                            if (_.isObject(resp.errors)) {
                                text = window.Misc.parseErrors(resp.errors);
                            }

                            if (!resp.success) {
                                alertify.error(text);
                                return;
                            }

                            // Add model in collection
                            _this.collection.add(model);
                            _this.collection.trigger('change');
                            window.Misc.clearForm(form);
                        }
                    },
                    error: function(model, error) {
                        window.Misc.removeSpinner(_this.parameters.wrapper);
                        alertify.error(error.statusText)
                    }
                });
        },

        /**
        *  Edit tiempo de produccion
        **/
        editOne: function(e) {
            e.preventDefault();

            var resource = this.$(e.currentTarget).data('resource');

            if (this.parameters.dataFilter.call == 'ordenp') {
                var model = new app.TiempopModel();
                this.searchTable.rows(function (idx, data, node) {
                    if (data.id == resource) {
                        model.set(data, {silent: true});
                    }
                    return false;
                });
            } else {
                var model = this.collection.get(resource);
            }

            // Open tiempopActionView
            if (this.tiempopActionView instanceof Backbone.View) {
               this.tiempopActionView.stopListening();
               this.tiempopActionView.undelegateEvents();
            }

            this.tiempopActionView = new app.TiempopActionView({
                model: model,
                parameters: {
                    call: this.parameters.dataFilter.call,
                    table: (this.searchTable || null)
                }
            });
           this.tiempopActionView.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner(this.parameters.wrapper);
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            window.Misc.removeSpinner(this.parameters.wrapper);
            if (!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if (_.isObject(resp.errors)) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if (!resp.success) {
                    alertify.error(text);
                    return;
                }
                // Validar que exista un modal
                if (this.$modal.length) {
                    this.collection.fetch({data: this.parameters.dataFilter, reset: true});
                    this.$modal.modal('hide');
                    alertify.success(resp.msg);
                }
            }
        }
   });

})(jQuery, this, this.document);
