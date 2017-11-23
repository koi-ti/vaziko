/**
* Class MainTiempopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTiempopView = Backbone.View.extend({

        el: '#tiempop-create',
        events: {
            'click .submit-tiempop': 'submitTiempop',
            'submit #form-tiempop': 'onStoreTiempop',
            'change #tiempop_actividadp': 'changeActividadp'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // collection
            this.tiempopList = new app.TiempopList();

            // Attributes
            this.$form = this.$('#form-tiempop');
            this.$subactividadesp = this.$('#tiempop_subactividadp');

            // Reference views and ready
            this.referenceViews();
            this.ready();
        },

        /*
        * Render View Element
        */
        render: function(){
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Despachos pendientes list
            this.tiempopListView = new app.TiempopListView( {
                collection: this.tiempopList,
                parameters: {
                    wrapper: this.el
                }
            });
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
                        window.Misc.setSpinner( _this.el );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );

                    if(resp.length > 0){
                        _this.$subactividadesp.empty().val(0).attr('required', 'required');
                        _this.$subactividadesp.append("<option value=></option>");
                        _.each(resp, function(item){
                            _this.$subactividadesp.append("<option value="+item.id+">"+item.subactividadp_nombre+"</option>");
                        });
                    }else{
                        _this.$subactividadesp.empty().val(0).removeAttr('required');
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(thrownError);
                });
            }else{
                this.$subactividadesp.empty().val(0);
            }
        },

        /**
        * Event submit productop
        */
        submitTiempop: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Forum Post
        */
        onStoreTiempop: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.tiempopList.trigger( 'store' , data );
            }
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

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
        },
    });

})(jQuery, this, this.document);
