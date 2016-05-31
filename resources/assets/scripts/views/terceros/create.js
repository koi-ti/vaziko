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
        template: _.template( ($('#add-tercero-tpl').html() || '') ),
        templateName: _.template( ($('#tercero-name-tpl').html() || '') ),
        events: {
            'change input#tercero_nit': 'nitChanged',
            'change select#tercero_persona': 'personaChanged',
            'change select#tercero_actividad': 'actividadChanged',
            'submit #form-create-tercero': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {      
            
            // Attributes 
            this.msgSuccess = 'Tercero guardado con exito!';
            this.$wraperForm = this.$('#render-form-tercero');

            // Events
            this.listenTo( this.model, 'change:id', this.render );
            this.listenTo( this.model, 'change:tercero_persona', this.renderName );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // Model exist
            if( this.model.id == undefined ) {
                this.renderName();
            }else{

                this.contactsList = new app.ContactsList();

                // Reference views
                this.referenceViews();
            }

            // Reference to fields
            this.$dv = this.$('#tercero_digito');
            this.$retecree = this.$('#tercero_retecree'); 
            
            this.ready();  
        },

        /**
        * render name
        */
        renderName: function (model, value, opts) {
            this.$('#content-render-name').html( this.templateName(this.model.toJSON()) );
            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper(); 

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();  

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();  

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck(); 
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });
        },

        nitChanged: function(e) {
            var _this = this;
            
            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.dv')),
                type: 'GET',
                data: { tercero_nit: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {  
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // Dv
                    _this.$dv.val(resp.dv);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        personaChanged: function(e) {
            this.model.set({ tercero_persona: $(e.currentTarget).val() });
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('terceros.show', { terceros: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);
