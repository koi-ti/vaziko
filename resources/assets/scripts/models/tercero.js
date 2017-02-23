/**
* Class TerceroModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TerceroModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('terceros.index') );
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
            'tercero_municipio' : '',
            'tercero_email' : '',
            'tercero_telefono1' : '',
            'tercero_telefono2' : '',
            'tercero_fax' : '',
            'tercero_celular' : '',
            'tercero_actividad' : '',
            'tercero_cc_representante' : '',
            'tercero_representante' : '',
            'tercero_activo': false,
            'tercero_responsable_iva': false,
            'tercero_autoretenedor_cree': false,
            'tercero_gran_contribuyente': false,
            'tercero_autoretenedor_renta': false,
            'tercero_autoretenedor_ica': false,
            'tercero_socio': false,
            'tercero_cliente': false,
            'tercero_acreedor': false,
            'tercero_interno': false,
            'tercero_mandatario': false,
            'tercero_empleado': false,
            'tercero_proveedor': false,
            'tercero_extranjero': false,
            'tercero_afiliado': false,
            'tercero_otro': false,
            'tercero_tecnico': false,
            'tercero_coordinador': false,
            'tercero_coordinador_por': '',
            'tercero_cual': '',
            'actividad_tarifa' : ''
        }
    });

})(this, this.document);
