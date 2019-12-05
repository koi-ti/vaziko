/**
* Class MainTiempopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTiempopView = Backbone.View.extend({

        el: '#tiemposp-main',
        template: _.template(($('#add-tiempop-tpl').html() || '')),
        events: {
            'submit #form-tiempop': 'onStore',
            'change #tiempop_actividadp': 'changeActividadp'
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            // Initialize
            if (opts !== undefined && _.isObject(opts.parameters))
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Collection
            this.tiempopList = new app.TiempopList();
        },

        /*
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
                attributes.ordenp = this.parameters.data.ordenp;

            // Render in wrapper
            this.$el.html(this.template(attributes));

            // Rerence wrappers for render
            this.spinner = this.$('.spinner-main');
            this.$form = this.$('#form-tiempop');
            this.$subactividadesp = this.$('#tiempop_subactividadp');

            // If exists ordnep
            if (this.parameters.data.ordenp)
                this.$('#tiempop_ordenp').val(attributes.ordenp).trigger('change');

            // Reference views
            this.referenceViews();
            this.ready();
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson(e.target);
                this.tiempopList.trigger('store', data, this.$form);
            }
        },

        /**
        * Event change select actividadp
        */
        changeActividadp: function(e) {
            var selected = this.$(e.currentTarget).val(),
                _this = this;

            if (selected) {
                window.Misc.setSpinner(_this.spinner);
                $.get(window.Misc.urlFull(Route.route('subactividadesp.index', {actividadesp: selected})), function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    if (resp.length > 0) {
                        _this.$subactividadesp.empty().val(0).prop('required', true).removeAttr('disabled');
                        _this.$subactividadesp.append("<option value></option>");
                        _.each(resp, function (item) {
                            _this.$subactividadesp.append("<option value=" + item.id + ">" + item.subactividadp_nombre + "</option>");
                        });
                    } else {
                        _this.$subactividadesp.empty().prop('disabled', true);
                    }
                });
            } else {
                this.$subactividadesp.empty().val(0).prop('disabled', true);
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Despachos pendientes list
            this.tiempopListView = new app.TiempopListView({
                collection: this.tiempopList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        call: 'tiemposp'
                    }
                }
            });
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if (typeof window.initComponent.initValidator == 'function')
                window.initComponent.initValidator();

            if (typeof window.initComponent.initDatePicker == 'function')
                window.initComponent.initDatePicker();

            if (typeof window.initComponent.initClockPicker == 'function')
                window.initComponent.initClockPicker();

            if (typeof window.initComponent.initToUpper == 'function')
                window.initComponent.initToUpper();

            if (typeof window.initComponent.initSelect2 == 'function')
                window.initComponent.initSelect2();
        },

        // /**
        // * Load spinner on the request
        // */
        // loadSpinner: function (model, xhr, opts) {
        //     window.Misc.setSpinner(this.spinner);
        // },
        //
        // /**
        // * response of the server
        // */
        // responseServer: function (model, resp, opts) {
        //     window.Misc.removeSpinner( this.spinner);
        //     if(!_.isUndefined(resp.success)) {
        //         // response success or error
        //         var text = resp.success ? '' : resp.errors;
        //         if (_.isObject(resp.errors)) {
        //             text = window.Misc.parseErrors(resp.errors);
        //         }
        //
        //         if (!resp.success) {
        //             alertify.error(text);
        //             return;
        //         }
        //
        //         window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('tiemposp.index')));
        //     }
        // }
    });

})(jQuery, this, this.document);
