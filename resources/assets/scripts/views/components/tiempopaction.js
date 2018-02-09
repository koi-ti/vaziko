/**
* Class TiempopActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopActionView = Backbone.View.extend({

        el: 'body',
        templateTiempop: _.template(($('#edit-tiempop-tpl').html() || '')),
        templateTiempopOrdenp: _.template(($('#edit-tiempop-ordenp-tpl').html() || '')),
        events: {
            'click .submit-ordenp': 'submitForm',
            'submit #form-edit-tiempop-component': 'onUpdateModel',
            'change .change-actividadp': 'changeActividadp',
        },
        parameters: {
            ordenp2: null,
            data: null,
            action: null,
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalTpO = $('#modal-tiempop-ordenp-edit');
            this.$modalTp = $('#modal-tiempop-edit');
            this.$form =  this.$('#form-edit-tiempop-component');
        },

        /*
        * Render View Element
        */
        render: function() {
            this.runAction();
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
        },

        runAction: function() {
            var _this = this;

            this.modelExits = _.find(this.collection.models, function(model) {
                return model.get('id') == _this.parameters.data;
            });

            var attributes = this.modelExits.attributes;

            if( this.parameters.action == 'ordenp' ){
                this.$modalTpO.find('.modal-title').text( 'Pestaña tiempo de producción - Editar # '+ attributes.id );
                this.$modalTpO.find('.content-modal').empty().html( this.templateTiempopOrdenp( attributes ) );

                // Reference tiempop pestaña ordenp
                this.referenceTiempopOrdenp();
            }else if( this.parameters.action == 'tiempop' ){
                this.$modalTp.find('.modal-title').text( 'Tiempo de producción - Editar # '+ attributes.id );
                this.$modalTp.find('.content-modal').empty().html( this.templateTiempop( attributes ) );

                // Reference tiempop modulo
                this.referenceTiempop();
            }else{
                return;
            }

            this.listenTo( this.modelExits, 'sync', this.responseServer );
            this.listenTo( this.modelExits, 'request', this.loadSpinner );
            this.ready();
        },

        /**
        * Reference tiempop pestaña de ordenp
        */
        referenceTiempopOrdenp: function( ) {
        	var _this = this;

            this.$wraper = this.$('#modal-tiempop-ordenp-wrapper');
            this.$wraperErrorTpO = this.$('#error-eval-tiempop-ordenp');
            this.$subactividadesp = this.$('#tiempop_subactividadp');

            // Hide errors
            this.$wraperErrorTpO.hide().empty();

            // Open modal
            this.$modalTpO.modal('show');
        },

        /**
        * Reference facturap
        */
        referenceTiempop: function( ) {
        	var _this = this;

            this.$wraper = this.$('#modal-tiempop-wrapper');
            this.$wraperErrorTp = this.$('#error-eval-tiempop');

            // Hide errors
            this.$wraperErrorTp.hide().empty();

            // Open modal
            this.$modalTp.modal('show');
        },

        /**
        * Event change select actividadp
        */
        changeActividadp: function(e) {
            var _this = this,
                actividadesp = this.$(e.currentTarget).val();

            if( typeof(actividadesp) !== 'undefined' && !_.isUndefined(actividadesp) && !_.isNull(actividadesp) && actividadesp != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subactividadesp.index', {actividadesp: actividadesp}) ),
                    type: 'GET',
                    beforeSend: function() {
                        _this.$wraperErrorTpO.hide().empty();
                        window.Misc.setSpinner( _this.$wraper );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraper );

                    // Limpiar subactividad cada vez que cambien de valor en actividadp
                    _this.$subactividadesp.empty().val(0);
                    if( resp.length > 0 ){
                        _this.$subactividadesp.append("<option value=></option>");
                        _.each(resp, function(item){
                            _this.$subactividadesp.append("<option value="+item.id+">"+item.subactividadp_nombre+"</option>");
                        });
                    }

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    _this.$wraperErrorTpO.empty().append( thrownError );
                    _this.$wraperErrorTpO.show();
                });
            }else{
                // Limpiar subactividad cada vez eliminen el actividadp de select2
                this.$subactividadesp.empty().val(0);
            }
        },

        /**
        * Event submit productop
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        *   Event update
        */
        onUpdateModel: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var model = this.modelExits;
                if(model instanceof Backbone.Model ) {
                    var data = window.Misc.formToJson( e.target );
                        data.call = this.parameters.action;

                    model.save( data, {patch: true, silent: true} );
                }
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraper );
        },


        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraper );

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

                alertify.success( resp.msg );
                if( this.$modalTpO.length > 0 ){
                    this.$modalTpO.modal('hide');
                    this.collection.fetch({ data: {orden2_orden: this.parameters.ordenp2} });
                }else if ( this.$modalTp.length > 0 ){
                    this.$modalTp.modal('hide');
                    this.collection.fetch();
                }
            }
        }
    });

})(jQuery, this, this.document);
