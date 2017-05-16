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
            'click .btn-edit-tcontacto': 'editOne',
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // Trigger
            this.on('createOne', this.createOne, this);

            this.collection.fetch({ data: {tercero_id: this.parameters.dataFilter.tercero_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object contactModel Model instance
        */
        addOne: function (contactModel) {
            var view = new app.ContactItemView( { model: contactModel } );
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },


        editOne: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( this.createTContactoView instanceof Backbone.View ){
                this.createTContactoView.stopListening();
                this.createTContactoView.undelegateEvents();
            }

            this.createTContactoView = new app.CreateTContactoView({
                model: model
            });
            this.createTContactoView.render();
        },

        createOne: function(tercero, address, nomenclatura, municipio) {
            var _this = this;

            if ( this.createTContactoView instanceof Backbone.View ){
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
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);
