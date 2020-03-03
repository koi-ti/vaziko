/**
* Class ContactsListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ContactsListView = Backbone.View.extend({

        el: '#browse-contact-list',
        events: {
            'click .item-edit': 'editOne',
            'click .item-state': 'stateOne',
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // Trigger
            this.on('createOne', this.createOne, this);

            this.collection.fetch({data: this.parameters.dataFilter, reset: true});
        },

        /**
        * Render view contact by model
        * @param Object contactModel Model instance
        */
        addOne: function (contactModel) {
            var view = new app.ContactItemView({
                model: contactModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            this.$el.append(view.render().el);
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach(this.addOne, this);
        },

        /**
        * Create one item
        */
        createOne: function(tercero, address, nomenclatura, municipio) {
            var _this = this;

            if (this.createTContactoView instanceof Backbone.View) {
                this.createTContactoView.stopListening();
                this.createTContactoView.undelegateEvents();
            }

            this.createTContactoView = new app.CreateTContactoView({
                model: new app.ContactoModel({
                    tcontacto_direccion: address,
                    tcontacto_direccion_nomenclatura: nomenclatura,
                    tcontacto_municipio: municipio
                }),
                collection: _this.collection,
                parameters: {
                    'tercero_id': tercero
               }
            });
            this.createTContactoView.render();
        },

        /**
        * Edit one item
        */
        editOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if (model.get('tcontacto_activo')) {
                if (this.createTContactoView instanceof Backbone.View) {
                    this.createTContactoView.stopListening();
                    this.createTContactoView.undelegateEvents();
                }

                this.createTContactoView = new app.CreateTContactoView({
                    model: model
                });
                this.createTContactoView.render();
            }
        },

        /**
        * Change state one item
        */
        stateOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if (model instanceof Backbone.Model) {
                var stateConfirm = new window.app.ConfirmWindow({
                    parameters: {
                        dataFilter: {
                            nombre: model.get('tcontacto_nombres') + ' ' + model.get('tcontacto_apellidos'),
                            activo: model.get('tcontacto_activo')
                        },
                        template: _.template(($('#tcontacto-state-confirm-tpl').html() || '')),
                        titleConfirm: 'Estado del contacto',
                        onConfirm: function () {
                            $.ajax({
                                url: window.Misc.urlFull(Route.route('terceros.contactos.estado', {contacto: model.get('id')})),
                                type: 'GET',
                                beforeSend: function () {
                                    window.Misc.setSpinner(_this.el);
                                }
                            })
                            .done(function (resp) {
                                if (!_.isUndefined(resp.success)) {
                                    window.Misc.removeSpinner(_this.el);
                                    // response success or error
                                    var text = resp.success ? resp.msg : resp.errors;
                                    if (!resp.success) {
                                        alertify.error(text);
                                        return;
                                    }

                                    alertify.success(resp.msg);
                                    _this.collection.fetch({data: _this.parameters.dataFilter, reset: true});
                                }
                            })
                            .fail(function (jqXHR, ajaxOptions, thrownError) {
                                window.Misc.removeSpinner(_this.el);
                                alertify.error(thrownError);
                            });
                        }
                    }
                });
                stateConfirm.render();
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner(this.el);
        },

        /**
        * response of the server
        */
        responseServer: function (target, resp, opts) {
            window.Misc.removeSpinner(this.el);
        }
   });

})(jQuery, this, this.document);
