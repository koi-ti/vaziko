/**
* Class CreateTiempoOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTiempoOrdenpView = Backbone.View.extend({

        el: '#tiempoordenp-create',
        template: _.template( ($('#add-tiempoordenp-tpl').html() || '') ),
        events: {
            'click .submit-tiempoordenp': 'submitTiempoOrdenp',
            'click .btn-edit-tiempoordenp': 'editTiempoOrdenp',
            'submit #form-tiempoordenp': 'onStoreTiempoOrdenp',
            'change #tiempoordenp_actividadop': 'changeActividadOp'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-tiempoordenp');
            this.$modalGeneric = $('#modal-producto-generic');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // Attributes
            this.$form = this.$('#form-tiempoordenp');
            this.$subactividadesop = this.$('#tiempoordenp_subactividadop');

            this.ready();
        },

        /**
        * Event change select actividadop
        */
        changeActividadOp: function(e) {
            var _this = this,
                actividadesop = this.$(e.currentTarget).val();

            if( typeof(actividadesop) !== 'undefined' && !_.isUndefined(actividadesop) && !_.isNull(actividadesop) && actividadesop != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subactividadesop.index', {actividadesop: actividadesop}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );

                    _this.$subactividadesop.empty().val(0);
                    _this.$subactividadesop.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subactividadesop.append("<option value="+item.id+">"+item.subactividadop_nombre+"</option>");
                    });
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }else{
                this.$subactividadesop.empty().val(0);
            }
        },

        /**
        * Event submit productop
        */
        submitTiempoOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Forum Post
        */
        onStoreTiempoOrdenp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true} );
            }
        },

        editTiempoOrdenp: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // tercero, tcontacto, vencimiento and servicio
            //     this.$modalGeneric.modal('show');
            //
            //     // Open TecnicoActionView
            //     if ( this.productoActionView instanceof Backbone.View ){
            //         this.productoActionView.stopListening();
            //         this.productoActionView.undelegateEvents();
            //     }
            //
            //     this.productoActionView = new app.ProductoActionView({
            //         model: this.model,
            //         parameters: {
            //             call: 'M'
            //         }
            //     });
            //
            //     this.productoActionView.render();
            // }
            }
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

                alertify.success(resp.msg);
                window.Misc.clearForm( this.$form );
                this.model.fetch();
	     	}
        }
    });

})(jQuery, this, this.document);
