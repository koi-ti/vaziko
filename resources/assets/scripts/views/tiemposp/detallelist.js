/**
* Class TiempopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopListView = Backbone.View.extend({

        el: '#browse-tiemposp-list',
        events: {
            'click .edit-tiempop': 'editTiempop',
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.$modal = $('#modal-edit-tiempop');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch();
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        *  Edit tiempo de produccion
        **/
        editTiempop: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var tiempo = {
                    id: this.$(e.currentTarget).data('tiempo-resource'),
                    fecha: this.$(e.currentTarget).data('tiempo-fecha'),
                    horai: this.$(e.currentTarget).data('tiempo-hi'),
                    horaf: this.$(e.currentTarget).data('tiempo-hf')
                };

                this.$modal.modal('show');

                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.tiempopActionView = new app.TiempopActionView({
                    parameters: {
                        collection: this.collection,
                        model: tiempo
                    }
                });

                this.tiempopActionView.render();
            }
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopItemView({
                model: tiempopModel
            });
            tiempopModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * store
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );
            //
            // Add model in collection
            var tiempopModel = new app.TiempopModel();
            tiempopModel.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                        window.Misc.clearForm( $('#form-tiempop') );
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        }
   });

})(jQuery, this, this.document);
