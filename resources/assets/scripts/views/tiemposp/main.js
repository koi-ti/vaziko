/**
* Class MainTiempopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTiempopView = Backbone.View.extend({

        el: '#tiempop-main',
        events: {
            'click .submit-tiempop': 'submitForm',
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

            // collection && Attributes
            this.tiempopList = new app.TiempopList();
            this.$form = this.$('#form-tiempop');
            this.$subactividadesp = this.$('#tiempop_subactividadp');

            // Events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            // Reference views and ready
            this.spinner = $('.spinner-main');

            if (this.parameters.data.ordenp) {
                $('#tiempop_ordenp').val(this.parameters.data.ordenp).trigger('change');
            }

            this.referenceViews();
            this.ready();
        },

        /**
        * Event change select actividadp
        */
        changeActividadp: function (e) {
            var actividadesp = this.$(e.currentTarget).val(),
                _this = this;

            if (typeof(actividadesp) !== 'undefined' && !_.isUndefined(actividadesp) && !_.isNull(actividadesp) && actividadesp != '') {
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subactividadesp.index', {actividadesp: actividadesp}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner(_this.spinner);
                    }
                })
                .done(function (resp) {
                    window.Misc.removeSpinner(_this.spinner);
                    if (resp.length > 0) {
                        _this.$subactividadesp.empty().val(0).attr('required', 'required');
                        _this.$subactividadesp.append("<option value=></option>");
                        _.each(resp, function (item) {
                            _this.$subactividadesp.append("<option value=" + item.id + ">" + item.subactividadp_nombre + "</option>");
                        });
                    } else {
                        _this.$subactividadesp.empty().val(0).removeAttr('required');
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner(_this.spinner);
                    alertify.error(thrownError);
                });
            } else {
                this.$subactividadesp.empty().val(0);
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Despachos pendientes list
            this.tiempopListView = new app.TiempopListView( {
                collection: this.tiempopList,
                parameters: {
                    wrapper: this.spinner,
                    dataFilter: {
                        type: 'tiemposp'
                    }
                }
            });
        },

        /**
        * Event submit productop
        */
        submitForm: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save(data, {wait: true, patch: true, silent: true});
            }
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

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner(this.spinner);
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {
            window.Misc.removeSpinner( this.spinner);
            if(!_.isUndefined(resp.success)) {
                // response success or error
                var text = resp.success ? '' : resp.errors;
                if (_.isObject(resp.errors)) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if (!resp.success) {
                    alertify.error(text);
                    return;
                }

                window.Misc.successRedirect(resp.msg, window.Misc.urlFull(Route.route('tiemposp.index')));
            }
        }
    });

})(jQuery, this, this.document);
