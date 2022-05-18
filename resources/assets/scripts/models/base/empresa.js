/**
* Class EmpresaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.EmpresaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('empresa.index'));
        },
        idAttribute: 'id',
        defaults: {
            'tercero_nit': '',
            'tercero_digito': '',
            'tercero_regimen' : '',
            'tercero_tipo' : '',
			'tercero_persona' : '',
            'tercero_razonsocial' : '',
            'tercero_nombre1' : '',
            'tercero_nombre2' : '',
            'tercero_apellido1' : '',
            'tercero_apellido2' : '',
            'tercero_direccion' : '',
            'tercero_direccion_nomenclatura' : '',
            'tercero_municipio' : '',
            'tercero_email' : '',
            'tercero_telefono1' : '',
            'tercero_telefono2' : '',
            'tercero_fax' : '',
            'tercero_celular' : '',
            'tercero_actividad' : '',
            'tercero_cc_representante' : '',
            'tercero_representante' : '',
            'tercero_responsable_iva': false,
            'tercero_autoretenedor_cree': false,
            'tercero_gran_contribuyente': false,
            'tercero_autoretenedor_renta': false,
            'tercero_autoretenedor_ica': false,
            'tercero_formapago' : '',
            'actividad_tarifa' : '',
            'empresa_niif' : '',
            'empresa_round' : false,
            'empresa_paginacion': 1,
            'empresa_iva' : ''
        }
    });

})(this, this.document);
