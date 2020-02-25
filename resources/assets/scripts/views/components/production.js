/**
* Class ComponentProductionView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentProductionView = Backbone.View.extend({

      	el: 'body',
		events: {
            'ifChanged .production-check-measurements': 'checkProductionMedidas',
            'change .production-calculate-formula': 'changeProductionCalculateFormula',
            'change .change-production-materialp': 'changeProductionMaterialp',
            'change .change-production-areap': 'changeProductionAreap',
            'change .change-production-tipoproductop': 'changeProductionTipoProducto',
            'change .change-production-actividadp': 'changeProductionActividadp',
		},

        /**
        * Event change check tiro \\ retiro
        */
        checkProductionMedidas: function (e) {
            var option = this.$(e.currentTarget),
                resource = option.data('resource'),
                check = option.is(':checked'),
                type = option.val();

            var name = resource + '_tiro';
            if (type == name) {
                // Tiro
                this.$('#' + resource + '_yellow').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_magenta').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_cyan').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_key').iCheck(check ? 'check' : 'uncheck');
            } else {
                // Retiro
                this.$('#' + resource + '_yellow2').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_magenta2').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_cyan2').iCheck(check ? 'check' : 'uncheck');
                this.$('#' + resource + '_key2').iCheck(check ? 'check' : 'uncheck');
            }
        },

        /**
        * Event change formulas
        */
        changeProductionCalculateFormula: function (e) {
            var reg = /[0-9/\+/\-/\*/\/\/\./\(/\)/]/,
                string = this.$(e.currentTarget).val(),
                response = this.$(e.currentTarget).data('response'),
                valor  = '';

            for (var i = 0; i <= string.length - 1; i++) {
                if (reg.test( string.charAt(i))) {
                    valor += string.charAt(i);
                }
            }

            // remplazar campos no validos y hacer operacion matematica
            this.$(e.currentTarget).val(valor);
            this.$('#' + response).val(eval(valor)).trigger('change');
        },

        /**
        * Event change materialp
        */
        changeProductionMaterialp: function (e) {
            var materialp = this.$(e.currentTarget).val(),
                reference = this.$(e.currentTarget).data('reference'),
                _this = this;

            // Reference
            this.$referenceselected = this.$('#' + this.$(e.currentTarget).data('field'));
            this.$referencewrapper = this.$('#' + this.$(e.currentTarget).data('wrapper'));
            this.$selectedinput = this.$('#' + this.$referenceselected.data('valor'));
            this.$selectedhistorial = this.$('#' + this.$referenceselected.data('historial'));

            if (typeof(materialp) !== 'undefined' && !_.isUndefined(materialp) && !_.isNull(materialp) && materialp != '') {
                window.Misc.setSpinner(this.$referencewrapper);
                $.get(window.Misc.urlFull(Route.route('search.productos', {materialp: materialp, reference: reference})), function (resp) {
                    if (resp.length) {
                        _this.$referenceselected.empty().val(0).removeAttr('disabled');
                        _this.$referenceselected.append("<option value=></option>");
                        _.each(resp, function(item) {
                            _this.$referenceselected.append("<option value=" + item.id + ">" + item.producto_nombre + "</option>");
                        });
                    } else {
                        _this.$referenceselected.empty().val(0).prop('disabled', true);
                        _this.$selectedinput.val(0);
                        _this.$selectedhistorial.empty();
                    }
                    window.Misc.removeSpinner(_this.$referencewrapper);
                });
            } else {
                this.$referenceselected.empty().val(0).prop('disabled', true);
                this.$selectedinput.val(0);
                this.$selectedhistorial.empty();
            }
        },

        /**
        * Event change areap
        */
        changeProductionAreap: function (e) {
            var option = this.$(e.currentTarget),
                name = option.attr('name'),
                resource = name.split('_')[0],
                areap = option.val(),
                _this = this;

            // Rerence inputs areasp
            this.$inputarea = this.$('#' + resource + '_nombre');
            this.$inputvalor = this.$('#' + resource + '_valor');

            // Reference wrapper
            this.$referencewrapper = this.$('#' + option.data('wrapper'));

            // Reference
            if (typeof(areap) !== 'undefined' && !_.isUndefined(areap) && !_.isNull(areap) && areap != '') {
                window.Misc.setSpinner(this.$referencewrapper);
                $.get(window.Misc.urlFull(Route.route('areasp.show', {areasp: areap})), function (resp) {
                    if (resp) {
                        _this.$inputarea.val('').attr('readonly', true);
                        _this.$inputvalor.val(resp.areap_valor);
                    }
                    window.Misc.removeSpinner(_this.$referencewrapper);
                });
            } else {
                this.$inputarea.val('').attr('readonly', false);
                this.$inputvalor.val('');
            }
        },

        /**
        * Event change tipo producto
        */
        changeProductionTipoProducto: function (e) {
            var option = this.$(e.currentTarget),
                typeproduct = option.val(),
                _this = this;

            // Reference wrapper
            this.$referencewrapper = this.$('' + option.data('wrapper'));
            this.$subtypeproduct = this.$('#' + option.data('reference'));

            if (typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '') {
                window.Misc.setSpinner(_this.$referencewrapper);
                $.get(window.Misc.urlFull(Route.route('search.subtipoproductosp', {typeproduct: typeproduct})), function (resp) {
                    if (resp) {
                        _this.$subtypeproduct.empty().val(0);
                        _this.$subtypeproduct.append("<option value=></option>");
                        _.each(resp, function(item) {
                            _this.$subtypeproduct.append("<option value=" + item.id + ">" + item.subtipoproductop_nombre + "</option>");
                        });
                    }
                    window.Misc.removeSpinner(_this.$referencewrapper);
                });
            } else {
                this.$subtypeproduct.empty().val(0);
            }
        },

        /**
        * Event change select actividadp
        */
        changeProductionActividadp: function(e) {
            var option = this.$(e.currentTarget),
                selected = option.val(),
                _this = this;

            this.$referencewrapper = this.$('' + option.data('wrapper'));
            this.$subactividadesp = this.$('#' + option.data('reference'));
            this.$wraperError = this.$('#error-eval-tiempop');

            if (selected) {
                if (this.$wraperError.length) {
                    this.$wraperError.hide().empty();
                }

                window.Misc.setSpinner(this.$referencewrapper);
                $.get(window.Misc.urlFull(Route.route('search.subactividadesp', {actividadesp: selected})), function (resp) {
                    if (resp.length > 0) {
                        _this.$subactividadesp.empty().val(0).prop('required', true).removeAttr('disabled');
                        _this.$subactividadesp.append("<option value></option>");
                        _.each(resp, function (item) {
                            _this.$subactividadesp.append("<option value=" + item.id + ">" + item.subactividadp_nombre + "</option>");
                        });
                    } else {
                        _this.$subactividadesp.empty().prop('disabled', true);
                    }
                    window.Misc.removeSpinner(_this.$referencewrapper);
                });
            } else {
                this.$subactividadesp.empty().val(0).prop('disabled', true);
            }
        },
    });
})(jQuery, this, this.document);
