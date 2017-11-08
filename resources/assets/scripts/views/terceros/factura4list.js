/**
* Class RolesListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.Factura4ListView = Backbone.View.extend({

        el: '#browse-factura4-list',
        parameters: {
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$valor = this.$('.total');
            this.$totalCount = this.$('#total_count');

            // Info adicional
            this.$porvencer = this.$('#porvencer');
            this.$porvencer_saldo = this.$('#porvencer_saldo');
            this.$menor30 = this.$('#menor30');
            this.$menor30_saldo = this.$('#menor30_saldo');
            this.$menor60 = this.$('#menor60');
            this.$menor60_saldo = this.$('#menor60_saldo');
            this.$menor90 = this.$('#menor90');
            this.$menor90_saldo = this.$('#menor90_saldo');
            this.$menor180 = this.$('#menor180');
            this.$menor180_saldo = this.$('#menor180_saldo');
            this.$menor360 = this.$('#menor360');
            this.$menor360_saldo = this.$('#menor360_saldo');
            this.$mayor360 = this.$('#mayor360');
            this.$mayor360_saldo = this.$('#mayor360_saldo');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {tercero: this.parameters.dataFilter.tercero , factura1: this.parameters.dataFilter.factura1}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view rol by model
        * @param Object contactModel Model instance
        */
        addOne: function (factura4Model) {
            var view = new app.Factura4ItemView({
                model: factura4Model,
                parameters: {
                    edit: this.parameters.edit,
                    call: this.parameters.call,
                    template: this.parameters.template,
                }
            });
            factura4Model.view = view;
            this.$el.prepend( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Render totalize valor
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$valor.length) {
                this.$valor.html( window.Misc.currency(data.valor) );
            }

            if(this.$porvencer.length) {
                this.$totalCount.html( data.tcount );
                this.$porvencer.html( data.porvencer.count );
                this.$porvencer_saldo.html( window.Misc.currency( data.porvencer.saldo ) );
            }

            if(this.$menor30.length) {
                this.$menor30.html( data.menor30.count );
                this.$menor30_saldo.html( window.Misc.currency( data.menor30.saldo ) );
            }

            if(this.$menor60.length) {
                this.$menor60.html( data.menor60.count );
                this.$menor60_saldo.html( window.Misc.currency( data.menor60.saldo ) );
            }

            if(this.$menor90.length) {
                this.$menor90.html( data.menor90.count );
                this.$menor90_saldo.html( window.Misc.currency( data.menor90.saldo ) );
            }

            if(this.$menor180.length) {
                this.$menor180.html( data.menor180.count );
                this.$menor180_saldo.html( window.Misc.currency( data.menor180.saldo ) );
            }

            if(this.$menor360.length) {
                this.$menor360.html( data.menor360.count );
                this.$menor360_saldo.html( window.Misc.currency( data.menor360.saldo ) );
            }

            if(this.$mayor360.length) {
                this.$mayor360.html( data.mayor360.count );
                this.$mayor360_saldo.html( window.Misc.currency( data.mayor360.saldo ) );
            }

        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);
