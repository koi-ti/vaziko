/**
* Class CreateRolView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateRolView = Backbone.View.extend({

        el: '#rol-create',
        template: _.template( ($('#add-rol-tpl').html() || '') ),
        events: {
            'click .submit-rol': 'submitRol',
            'submit #form-roles': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-rol');

            if( this.model.id != undefined ) {
                this.moduloList = new app.ModuloList();
            }

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            
            this.$form = this.$('#form-roles');

            // Model exist
            if( this.model.id != undefined ) {

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Tips list
            this.modulosListView = new app.ModulosListView( {
                collection: this.moduloList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-modulos'),
                    dataFilter: {
                        'modulo_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitRol: function (e) {
            this.$form.submit();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.el );

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

                // Redirect to edit rol
                Backbone.history.navigate(Route.route('roles.edit', { roles: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);
