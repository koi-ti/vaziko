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
        templateName: _.template( ($('#name-partner-tpl').html() || '') ),
        events: {
            'change input#tercero_nit': 'nitChanged',
            'change select#tercero_persona': 'personaChanged',
            'change select#tercero_actividad': 'actividadChanged',
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
            
            // Attributes 
            this.msgSuccess = 'Tercero guardado con exito!';
            this.$dv = this.$('#tercero_digito');
            this.$documento = this.$('#tercero_tipo');
            this.$persona = this.$('#tercero_persona');
            this.$retecree = this.$('#tercero_retecree');

            // Events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){

            this.$persona.change();
        },

        nitChanged: function(e) {
            var _this = this;
            
            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.dv')),
                type: 'GET',
                data: { tercero_nit: $(e.currentTarget).val() },
                beforeSend: function() {
                    _this.clearNitChange();
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {  
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // Dv
                    _this.$dv.val(resp.dv);
                    // Documento
                    if(!_.isUndefined(resp.documento) && !_.isNull(resp.documento)){
                        _this.$documento.val(resp.documento);
                    }

                    // Documento
                    if(!_.isUndefined(resp.persona) && !_.isNull(resp.persona)){
                        _this.$persona.val(resp.persona).change();
                    }
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        clearNitChange: function() {
            this.$dv.val('');  
            this.$documento.val('');  
            this.$persona.val('');  
        },

        personaChanged: function(e) {
            this.$('#name-partner-content').html( this.templateName({ persona: $(e.currentTarget).val() }) );
            
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        },

        actividadChanged: function(e) {
            var _this = this;
            
            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.rcree')),
                type: 'GET',
                data: { tercero_actividad: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {  
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // % cree
                    if(!_.isUndefined(resp.rcree) && !_.isNull(resp.rcree)){
                        _this.$retecree.html(resp.rcree);
                    }
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
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
