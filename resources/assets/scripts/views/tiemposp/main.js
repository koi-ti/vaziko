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
            'submit #form-tiempop': 'onStore'
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
        }
    });

})(jQuery, this, this.document);
