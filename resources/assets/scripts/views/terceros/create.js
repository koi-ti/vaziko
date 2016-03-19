/**
* Class CreateTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTerceroView = Backbone.View.extend({

        el: '#tercero-create',
        events: {
            'change input#tercero_nit': 'nitChanged',
            'submit #form-create-tercero': 'onStore'
        },
        parameters: {
            callback : ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {      
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            
            this.msgSuccess = 'Tercero guardado con exito!';

            // Events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        nitChanged: function(e) {
            console.log('Documento cambio')
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {
            
                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true} );                
            }
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

            // response success or error
            var text = resp.success ? '' : resp.errors;
            if( _.isObject( resp.errors ) ) {
                text = window.Misc.parseErrors(resp.errors);
            }

            if( !resp.success ) {
                alertify.error(text);
                return;
            }

            // stuffToDo Callback
            var _this = this,
                stuffToDo = {
                    'toEdit' : function() {
                        window.Misc.successRedirect(_this.msgSuccess, window.Misc.urlFull( Route.route('terceros.edit', { terceros: resp.id})) );            

                    },

                    'default' : function() {
                        alertify.success(_this.msgSuccess);
                    }
                };

            if (stuffToDo[this.parameters.callback]) {
                stuffToDo[this.parameters.callback]();
            } else {
                stuffToDo['default']();
            }
        }
    });

})(jQuery, this, this.document);
