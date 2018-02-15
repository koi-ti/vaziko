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
            'submit #form-edit-tiempop-component': 'updateModel',
            'change .change-actividadp': 'changeActividadp',
        },
        parameters: {
            data: null,
            dataFilter: null,
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-tiempop-edit-component');
            this.$wraper = this.$('#modal-tiempop-wrapper');
            this.$wraperError = this.$('#error-eval-tiempop');
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
            var attributes = this.model.toJSON();

            if( this.parameters.dataFilter.type == 'ordenp' ){
                this.$modal.find('.modal-dialog').addClass('modal-lg');
                this.$modal.find('.modal-title').text( 'Pestaña tiempo de producción - Editar # '+ attributes.id );
                this.$modal.find('.content-modal').empty().html( this.templateTiempopOrdenp( attributes ) );

                // Recuperar input subactividad
                this.$subactividadesp = this.$('#tiempop_subactividadp');

            }else if( this.parameters.dataFilter.type == 'tiemposp' ){
                this.$modal.find('.modal-dialog').addClass('modal-md')
                this.$modal.find('.modal-title').text( 'Tiempo de producción - Editar # '+ attributes.id );
                this.$modal.find('.content-modal').empty().html( this.templateTiempop( attributes ) );

            }else{
                return;
            }

            // Hide errors && Open modal
            this.$wraperError.hide().empty();
            this.$modal.modal('show');

            this.ready();
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
                        _this.$wraperError.hide().empty();
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
                    _this.$wraperError.empty().append( thrownError );
                    _this.$wraperError.show();
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
        updateModel: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.type = this.parameters.dataFilter.type;

                this.model.save( data, {patch: true, silent: true} );
            }
        }
    });

})(jQuery, this, this.document);
