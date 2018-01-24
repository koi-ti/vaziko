/**
* Class AcabadopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('acabadosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'acabadop_nombre': '',
            'acabadop_descripcion': ''
        }
    });

})(this, this.document);

/**
* Class ActividadModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActividadModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('actividades.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'actividad_codigo': '',	
        	'actividad_nombre': '',	
        	'actividad_tarifa': '0',	
        	'actividad_categoria': ''	
        }
    });

})(this, this.document);

/**
* Class ActividadpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ActividadpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('actividadesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'actividadp_nombre': '',
            'actividadp_activo': 1
        }
    });

})(this, this.document);

/**
* Class AreapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('areasp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'areap_nombre': '',
            'areap_valor': 0
        }
    });

})(this, this.document);

/**
* Class AsientoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.index') );
        },
        idAttribute: 'id',
        defaults: {
			'asiento1_ano': moment().format('YYYY'),
			'asiento1_mes': moment().format('M'),
			'asiento1_dia': moment().format('D'),
			'asiento1_folder': '',
			'asiento1_documento': '',
			'documento_tipo_consecutivo': '',
			'asiento1_numero': '',
			'asiento1_beneficiario': '',
			'tercero_nit': '',
			'tercero_nombre': '',
			'asiento1_sucursal': '',
			'asiento1_preguardado': '',
			'asiento1_detalle': '',
			'asiento1_fecha_elaboro': ''
		}
    });

})(this, this.document);

/**
* Class Asiento2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Asiento2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'asiento2_asiento': '',
            'asiento2_cuenta': '',
            'asiento2_beneficiario': '',
            'asiento2_debito': 0,
            'asiento2_credito': 0,
            'asiento2_centro': '',
            'asiento2_base': 0,
            'asiento2_detalle': '',
            'asiento2_orden': '',
            'plancuentas_cuenta': '',
            'plancuentas_nombre': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'centrocosto_nombre': '',
            'ordenp_codigo': '',
            'ordenp_beneficiario': '',
        	'asientoNif2_id': '',
        }
    });

})(this, this.document);

/**
* Class AsientoMovModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoMovModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientos.detalle.movimientos') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

})(this, this.document);

/**
* Class AsientoNifModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNifModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientosnif.index') );
        },
        idAttribute: 'id',
        defaults: {
			'asienton1_ano': moment().format('YYYY'),
			'asienton1_mes': moment().format('M'),
			'asienton1_dia': moment().format('D'),
			'asienton1_folder': '',
			'asienton1_documento': '',
			'documento_tipo_consecutivo': '',
			'asienton1_numero': '',
			'asienton1_beneficiario': '',
			'tercero_nit': '',
			'tercero_nombre': '',
			'asienton1_sucursal': '',
			'asienton1_preguardado': '',
			'asienton1_detalle': '',
			'asienton1_fecha_elaboro': ''
		}
    });

})(this, this.document);

/**
* Class AsientoNif2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNif2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('asientosnif.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
            'asienton2_asiento': '',
            'asienton2_cuenta': '',
            'asienton2_beneficiario': '',
            'asienton2_debito': 0,
            'asienton2_credito': 0,
            'asienton2_centro': '',
            'asienton2_base': 0,
            'asienton2_detalle': '',
            'asienton2_orden': '',
            'plancuentasn_cuenta': '',
            'plancuentasn_nombre': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'centrocosto_nombre': '',
            'ordenp_codigo': '',
            'ordenp_beneficiario': '',
        }
    });

})(this, this.document);

/**
* Class CentroCostoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CentroCostoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('centroscosto.index') );
        },
        idAttribute: 'id',
        defaults: {
            'centrocosto_codigo': '',   
        	'centrocosto_centro': '',	
            'centrocosto_nombre': '',   
            'centrocosto_descripcion1': '',   
            'centrocosto_descripcion2': '',
            'centrocosto_estructura': 'N',
            'centrocosto_tipo': 'N',
        	'centrocosto_activo': true
        }
    });

})(this, this.document);

/**
* Class ContactoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContactoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('terceros.contactos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'tcontacto_nombres': '',
        	'tcontacto_apellidos': '',
        	'tcontacto_telefono': '',
        	'tcontacto_celular': '',
            'tcontacto_municipio': '',
            'tcontacto_direccion': '',
        	'tcontacto_direccion_nomenclatura': '',
        	'tcontacto_email': '',
        	'tcontacto_cargo': ''
        }
    });

})(this, this.document);
/**
* Class CotizacionModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CotizacionModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion1_codigo': '',
            'cotizacion1_referencia': '',
            'cotizacion1_cliente': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'tercero_direccion': '',
            'tercero_dir_nomenclatura': '',
            'tercero_municipio': '',
            'cotizacion1_fecha_inicio': moment().format('YYYY-MM-DD'),
            'cotizacion1_iva': '',
            'cotizacion1_contacto': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'cotizacion1_suministran': '',
            'cotizacion1_formapago': '',
            'cotizacion1_observaciones': '',
            'cotizacion1_terminado': ''
        }
    });

})(this, this.document);

/**
* Class Cotizacion2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Cotizacion2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion2_referencia': '',
            'cotizacion2_cantidad': 0,
            'cotizacion2_precio_formula': '',
            'cotizacion2_transporte_formula': '',
            'cotizacion2_viaticos_formula': '',
            'cotizacion2_precio_round': '',
            'cotizacion2_transporte_round': '',
            'cotizacion2_viaticos_round': '',
            'cotizacion2_precio_venta': '',
            'cotizacion2_transporte': 0,
            'cotizacion2_viaticos': 0,
            'cotizacion2_observaciones': '',
            'cotizacion2_ancho': 0,
            'cotizacion2_alto': 0,
            'cotizacion2_c_ancho': 0,
            'cotizacion2_c_alto': 0,
            'cotizacion2_3d_ancho': 0,
            'cotizacion2_3d_alto': 0,
            'cotizacion2_3d_profundidad': 0,
            'cotizacion2_tiro': false,
            'cotizacion2_yellow': false,
            'cotizacion2_magenta': false,
            'cotizacion2_cyan': false,
            'cotizacion2_key': false,
            'cotizacion2_color1': false,
            'cotizacion2_color2': false,
            'cotizacion2_nota_tiro': '',
            'cotizacion2_retiro': false,
            'cotizacion2_yellow2': false,
            'cotizacion2_magenta2': false,
            'cotizacion2_cyan2': false,
            'cotizacion2_key2': false,
            'cotizacion2_color12': false,
            'cotizacion2_color22': false,
            'cotizacion2_nota_retiro': '',
        }
    });

})(this, this.document);

/**
* Class Cotizacion3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Cotizacion3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.maquinas.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

})(this, this.document);

/**
* Class Cotizacion4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.materiales.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);

/**
* Class Cotizacion5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.acabados.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);

/**
* Class Cotizacion6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Cotizacion6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'cotizacion6_areap': '',
        	'cotizacion6_nombre': '',
            'cotizacion6_tiempo': '',
            'cotizacion6_valor': 0,
        	'areap_nombre': '',
        	'total': 0,
        }
    });

}) (this, this.document);

/**
* Class DespachopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.despachos.index') );
        },
        idAttribute: 'id',
        defaults: {
		}
    });

})(this, this.document);

/**
* Class DocumentoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DocumentoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('documentos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'documento_codigo': '',
        	'documento_nombre': '',
        	'documento_folder': '',
            'documento_tipo_consecutivo': 'A',
            'documento_nif':'',
            'documento_actual': 1,
        }
    });

})(this, this.document);

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
            return window.Misc.urlFull( Route.route('empresa.index') );
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
            'tercero_dir_nomenclatura' : '',
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
            'actividad_tarifa' : '',
            'empresa_niif' : '',
            'empresa_iva' : ''
        }
    });

})(this, this.document);

/**
* Class FacturaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'factura1_fecha': moment().format('YYYY-MM-DD'),
            'factura1_fecha_vencimiento': moment().format('YYYY-MM-DD'),
            'tercero_nit': '',
            'tercero_nombre': '',
        }
    });

})(this, this.document);

/**
* Class Factura2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.facturado.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
/**
* Class Factura3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.comentario.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);

/**
* Class Factura4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Factura4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturas.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);
/**
* Class FacturapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturap.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);

/**
* Class Facturap2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Facturap2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('facturap.cuotas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'facturap2_factura': '',
        	'facturap2_cuota': '',
        	'facturap2_vencimiento': '',
        	'facturap2_valor': 0,
        	'facturap2_saldo': 0
        }
    });

})(this, this.document);

/**
* Class FolderModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){
    
    app.FolderModel = Backbone.Model.extend({
        
        urlRoot: function () {
            return window.Misc.urlFull (Route.route('folders.index') ); 
        },
        idAttribute: 'id', 
        defaults: {
            'folder_codigo': '',   
            'folder_nombre': '' 
        }
    });
    
}) (this, this.document);
/**
* Class GrupoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.GrupoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('grupos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'grupo_codigo': '',
        	'grupo_nombre': ''
        }
    });

})(this, this.document);

/**
* Class ItemRolloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemRolloModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.rollos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'prodboderollo_item': 0,
        	'prodboderollo_centimetro': 0,
        	'prodboderollo_saldo': 0
        }
    });

})(this, this.document);

/**
* Class MaquinapModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinapModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('maquinasp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'maquinap_nombre': ''
        }
    });

})(this, this.document);

/**
* Class MaterialpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('materialesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'materialp_nombre': '',
            'materialp_descripcion': '',
            'materialp_tipomaterialp': '',
        }
    });

})(this, this.document);

/**
* Class ModuloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ModuloModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('roles.permisos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'name': '',
            'display_name': '',
            'nivel1': '',
            'nivel2': '',
            'nivel3': '',
            'nivel4': ''
        }
    });

})(this, this.document);

/**
* Class OrdenpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.OrdenpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden_codigo': '',
            'orden_referencia': '',
            'orden_cliente': '',
            'tercero_nit': '',
            'tercero_nombre': '',
            'tercero_direccion': '',
            'tercero_dir_nomenclatura': '',
            'tercero_municipio': '',
            'orden_fecha_inicio': moment().format('YYYY-MM-DD'),
            'orden_fecha_entrega': moment().format('YYYY-MM-DD'),
            'orden_hora_entrega': '',
            'orden_formapago': 'CO',
            'orden_iva': '',
            'orden_contacto': '',
            'tcontacto_nombre': '',
            'tcontacto_telefono': '',
            'orden_suministran': '',
            'orden_observaciones': '',
            'orden_terminado': ''
        }
    });

}) (this, this.document);
/**
* Class Ordenp2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden2_referencia': '',
            'orden2_cantidad': 0,
            'orden2_precio_formula': '',
            'orden2_transporte_formula': '',
            'orden2_viaticos_formula': '',
            'orden2_precio_round': '',
            'orden2_transporte_round': '',
            'orden2_viaticos_round': '',
            'orden2_transporte': 0,
            'orden2_viaticos': 0,
            'orden2_precio_venta': 0,
            'orden2_observaciones': '',
            'orden2_ancho': 0,
            'orden2_alto': 0,
            'orden2_c_ancho': 0,
            'orden2_c_alto': 0,
            'orden2_3d_ancho': 0,
            'orden2_3d_alto': 0,
            'orden2_3d_profundidad': 0,
            'orden2_tiro': false,
            'orden2_yellow': false,
            'orden2_magenta': false,
            'orden2_cyan': false,
            'orden2_key': false,
            'orden2_color1': false,
            'orden2_color2': false,
            'orden2_nota_tiro': '',
            'orden2_retiro': false,
            'orden2_yellow2': false,
            'orden2_magenta2': false,
            'orden2_cyan2': false,
            'orden2_key2': false,
            'orden2_color12': false,
            'orden2_color22': false,
            'orden2_nota_retiro': '',
        }
    });

}) (this, this.document);

/**
* Class Ordenp3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.maquinas.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);
/**
* Class Ordenp4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.materiales.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);
/**
* Class Ordenp5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.acabados.index') );
        },
        idAttribute: 'id',
        defaults: {

        }
    });

}) (this, this.document);
/**
* Class Ordenp6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.Ordenp6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('ordenes.productos.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
            'orden6_areap': '',
        	'orden6_nombre': '',
            'orden6_tiempo': '',
            'orden6_valor': 0,
        	'areap_nombre': '',
        	'total': 0,
        }
    });

}) (this, this.document);

/**
* Class PlanCuentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PlanCuentaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('plancuentas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'plancuentas_cuenta': '',	
        	'plancuentas_nivel': '',	
        	'plancuentas_nombre': '',	
        	'plancuentas_naturaleza': 'D',	
        	'plancuentas_centro': '',	
        	'plancuentas_tercero': false,	
        	'plancuentas_tipo': 'N',	
        	'plancuentas_tasa': 0,
            'plancuentas_equivalente':''
        }
    });

})(this, this.document);

/**
* Class PlanCuentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PlanCuentaNifModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('plancuentasnif.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'plancuentasn_cuenta': '',	
        	'plancuentasn_nivel': '',	
        	'plancuentasn_nombre': '',	
        	'plancuentasn_naturaleza': 'D',	
        	'plancuentasn_centro': '',	
        	'plancuentasn_tercero': 0,	
        	'plancuentasn_tipo': 'N',	
        	'plancuentasn_tasa': 0
        }
    });

})(this, this.document);

/**
* Class ItemRolloModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdBodeModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.prodbode.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);

/**
* Class ProductoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productos.index') );
        },
        idAttribute: 'id',
        defaults: {
            'producto_nombre': '',
            'producto_codigo': '',
            'producto_codigoori': '',
            'producto_referencia': '',
            'producto_grupo': '',
            'producto_subgrupo': '',
            'producto_unidadmedida': '',
            'producto_precio': 0,
            'producto_costo': 0,
            'producto_vidautil': 0,
            'producto_unidades': true,
            'producto_serie': false,
            'producto_metrado': false
        }
    });

})(this, this.document);

/**
* Class ProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'productop_nombre': '',
            'productop_observaciones': '',
            'productop_tiro': false,
            'productop_retiro': false,
            'productop_abierto': false,
            'productop_cerrado': false,
            'productop_3d': false,
            'productop_ancho_med': '',
            'productop_alto_med': '',
            'productop_c_med_ancho': '',
            'productop_c_med_alto': '',
            'productop_tipoproductop': '',
            'productop_subtipoproductop': '',
            'subtipoproductop_nombre': '',
            'productop_3d_profundidad_med': '',
            'productop_3d_ancho_med': '',
            'productop_3d_alto_med': ''
        }
    });

})(this, this.document);

/**
* Class Productop2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.tips.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop2_productop': '',
            'productop2_tip': ''
        }
    });

})(this, this.document);

/**
* Class Productop3Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop3Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.areas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop3_productop': '',
            'productop3_areap': ''
        }
    });

})(this, this.document);

/**
* Class Productop4Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop4Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.maquinas.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop4_productop': '',
            'productop4_maquinap': ''
        }
    });

})(this, this.document);

/**
* Class Productop5Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop5Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.materiales.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop5_productop': '',
            'productop5_materialp': ''
        }
    });

})(this, this.document);

/**
* Class Productop6Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Productop6Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('productosp.acabados.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'productop6_productop': '',
            'productop6_acabadop': ''
        }
    });

})(this, this.document);

/**
* Class PuntoVentaModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PuntoVentaModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('puntosventa.index') );
        },
        idAttribute: 'id',
        defaults: {
            'puntoventa_nombre': '',
            'puntoventa_numero': '',
            'puntoventa_prefijo': '',
            'puntoventa_resolucion_dian': ''
        }
    });

})(this, this.document);

/**
* Class RolModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RolModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('roles.index') );
        },
        idAttribute: 'id',
        defaults: {
            'name': '',
            'display_name': '',
            'description': '',
            'permissions': []
        }
    });

})(this, this.document);

/**
* Class SubActividadpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubActividadpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('subactividadesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'subactividadp_actividadp': '',
            'subactividadp_nombre': '',
            'subactividadp_activo': 1
        }
    });

})(this, this.document);

/**
* Class SubGrupoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubGrupoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('subgrupos.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'subgrupo_codigo': '',
        	'subgrupo_nombre': ''
        }
    });

})(this, this.document);

/**
* Class SubtipoProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SubtipoProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('subtipoproductosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'subtipoproductop_nombre': '',
            'subtipoproductop_tipoproductop': '',
            'subtipoproductop_activo': 1
        }
    });

})(this, this.document);

/**
* Class SucursalModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.SucursalModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('sucursales.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'sucursal_nombre': '',
        }
    });

})(this, this.document);

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
            'tercero_dir_nomenclatura' : '',
            'tercero_municipio' : '',
            'tercero_email' : '',
            'tercero_telefono1' : '',
            'tercero_telefono2' : '',
            'tercero_fax' : '',
            'tercero_celular' : '',
            'tercero_actividad' : '',
            'tercero_cc_representante' : '',
            'tercero_representante' : '',
            'tercero_formapago' : '',
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
            'username': '',
            'actividad_tarifa' : ''
        }
    });

})(this, this.document);

/**
* Class TiempopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tiemposp.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);

/**
* Class TipoMaterialpModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoMaterialpModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipomaterialesp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipomaterialp_nombre': '',
            'tipomaterialp_activo': 1
        }
    });

})(this, this.document);

/**
* Class TipoProductopModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipoProductopModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('tipoproductosp.index') );
        },
        idAttribute: 'id',
        defaults: {
            'tipoproductop_nombre': '',
            'tipoproductop_activo': 1
        }
    });

})(this, this.document);

/**
* Class TrasladoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('traslados.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'traslado1_sucursal': '',
        	'traslado1_numero': '',
        	'traslado1_destino': '',
        	'traslado1_fecha': moment().format('YYYY-MM-DD'),
        	'traslado1_observaciones': ''
		}
    });

})(this, this.document);
/**
* Class Traslado2Model extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.Traslado2Model = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('traslados.detalle.index') );
        },
        idAttribute: 'id',
        defaults: {
        }
    });

})(this, this.document);

/**
* Class UnidadModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UnidadModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('unidades.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'unidadmedida_sigla': '',
        	'unidadmedida_nombre': ''
        }
    });

})(this, this.document);

/**
* Class UsuarioRolModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.UsuarioRolModel = Backbone.Model.extend({
        urlRoot: function () {
            return window.Misc.urlFull( Route.route('terceros.roles.index') );
        },
        idAttribute: 'id',
        defaults: {
        	'user_id': '',
        	'role_id': ''
        }
    });

})(this, this.document);

/**
* Class AsientoCuentasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoCuentasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientos.detalle.index') );
        },
        model: app.Asiento2Model,

        /**
        * Constructor Method
        */
        initialize : function() {
        },

        debitos: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asiento2_debito'))
            }, 0);
        },

        creditos: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asiento2_credito'))
            }, 0);
        },

        totalize: function() {
            var debitos = this.debitos();
            var creditos = this.creditos();
            return { 'debitos': debitos, 'creditos': creditos, 'diferencia': Math.abs(creditos - debitos)}
        },
   });

})(this, this.document);

/**
* Class AsientoMovimientosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoMovimientosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientos.detalle.movimientos') );
        },
        model: app.AsientoMovModel,

        /**
        * Constructor Method
        */
        initialize : function() {

        }
   });

})(this, this.document);

/**
* Class AsientoNifCuentasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AsientoNifCuentasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('asientosnif.detalle.index') );
        },
        model: app.AsientoNif2Model,

        /**
        * Constructor Method
        */
        initialize : function() {
        },

        debitos: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asienton2_debito'))
            }, 0);
        },

        creditos: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('asienton2_credito'))
            }, 0);
        },

        totalize: function() {
            var debitos = this.debitos();
            var creditos = this.creditos();
            return { 'debitos': debitos, 'creditos': creditos, 'diferencia': Math.abs(creditos - debitos)}
        },
   });

})(this, this.document);

/**
* Class AcabadosProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.acabados.index') );
        },
        model: app.Cotizacion5Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class AreasProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.areas.index') );
        },
        model: app.Cotizacion6Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function( data ) {
            var error = { success: false, message: '' };

            // Validate exist
            if( !_.isNull(data.cotizacion6_areap) && !_.isUndefined(data.cotizacion6_areap) && data.cotizacion6_areap != ''){
                var modelExits = _.find(this.models, function(item) {
                    return item.get('cotizacion6_areap') == data.cotizacion6_areap;
                });
            }else{
                var modelExits = _.find(this.models, function(item) {
                    return item.get('cotizacion6_nombre') == data.cotizacion6_nombre;
                });
            }

            if(modelExits instanceof Backbone.Model ) {
                error.message = 'El area que intenta ingresar ya existe.'
                return error;
            }

            error.success = true;
            return error;
        },

        total: function() {
            var _this = this;

            return this.reduce(function(sum, model) {

                var func = _this.convertirMinutos( model );
                return sum + func * parseFloat(model.get('cotizacion6_valor'));

            }, 0);
        },

        totalRow: function( ){
            var _this = this;

            _.each(this.models, function(item){

                var func = _this.convertirMinutos( item ),
                    total = func * parseFloat(item.get('cotizacion6_valor'));
                item.set('total', Math.round( total ) );

            });
        },

        convertirMinutos: function ( model ){
            var tiempo = model.get('cotizacion6_tiempo').split(':'),
                horas = parseInt( tiempo[0] ),
                minutos = parseInt( tiempo[1] );

            // Regla de 3 para convertir min a horas
            var total = horas + (minutos / 60);

            return parseFloat( total );
        },

        totalize: function(  ) {
            var total = this.total();
            this.totalRow();
            return { 'total': Math.round(total) }
        },
   });

})(this, this.document);

/**
* Class MaquinasProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.maquinas.index') );
        },
        model: app.Cotizacion3Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class MaterialesProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.materiales.index') );
        },
        model: app.Cotizacion4Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class ProductopCotizacionList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopCotizacionList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('cotizaciones.productos.index') );
        },
        model: app.Cotizacion2Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        unidades: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion2_cantidad'))
            }, 0);
        },

        facturado: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('cotizacion2_facturado'))
            }, 0);
        },

        subtotal: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('cotizacion2_precio_total'))
            }, 0);
        },

        totalize: function() {
            var unidades = this.unidades();
            var facturado = this.facturado();
            var subtotal = this.subtotal();
            return { 'unidades': unidades, 'facturado': facturado, 'subtotal': subtotal}
        },
   });

})(this, this.document);

/**
* Class DetalleFactura2List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFactura2List = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturas.facturado.index') );
        },
        model: app.Factura2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        facturado: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('factura2_cantidad'))
            }, 0);
        },

        validar: function( data ){
            var response = {success: false, error: ''}

            // Validate exist
            var modelExits = _.find(this.models, function( item ) {
                return item.get('id') == data.factura1_orden;
            });

            if(modelExits instanceof Backbone.Model ) {
                response.error = 'La orden No. '+ data.factura1_orden +' ya se encuentra registrada.';
                return response;
            }

            response.success = true;
            return response;
        },

        renderSubtotal: function(){
            _.each(this.models, function(item){
                var total = parseInt(item.get('factura2_cantidad')) * parseFloat(item.get('orden2_total_valor_unitario'));
                $('#subtotal_'+item.get('id') ).html( window.Misc.currency(total) );
            });
        },

        totalize: function() {
            var facturado = this.facturado();
            // var subtotal = this.subtotal();
            this.renderSubtotal();
            return { 'facturado': facturado }
        },
   });

})(this, this.document);

/**
* Class DetalleFactura4List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFactura4List = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('facturas.detalle.index') );
        },
        model: app.Factura4Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('factura4_saldo'))
            }, 0);
        },

        calculate: function(modelos){
            var saldo = _.reduce(modelos, function(sum, model) {
                return sum + parseFloat(model.get('factura4_saldo'))
            }, 0);

            var count = modelos.length;

            return { 'saldo': saldo, 'count': count}
        },

        matchPorvencer: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') > 0;
            });

            return this.calculate(match);
        },

        matchMayor360: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') < -360;
            });

            return this.calculate(match);
        },

        matchMenor360: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -181 && item.get('days') >= -360;
            });

            return this.calculate(match);
        },

        matchMenor180: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -91 && item.get('days') >= -180;
            });

            return this.calculate(match);
        },

        matchMenor90: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -61 && item.get('days') >= -90;
            });

            return this.calculate(match);
        },

        matchMenor60: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -31 && item.get('days') >= -60;
            });

            return this.calculate(match);
        },

        matchMenor30: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= 0 && item.get('days') >= -30;
            });

            return this.calculate(match);
        },

        totalize: function() {
            var valor = this.valor();
            var porvencer = this.matchPorvencer();
            var mayor360 = this.matchMayor360();
            var menor360 = this.matchMenor360();
            var menor180 = this.matchMenor180();
            var menor90 = this.matchMenor90();
            var menor60 = this.matchMenor60();
            var menor30 = this.matchMenor30();
            var tcount = porvencer.count + menor30.count + menor60.count + menor90.count + menor180.count +menor360.count + mayor360.count;

            return { 'valor': valor, 'porvencer': porvencer, 'mayor360': mayor360, 'menor360': menor360, 'menor180': menor180, 'menor90': menor90, 'menor60': menor60, 'menor30': menor30, 'tcount': tcount}
        },
   });
})(this, this.document);
/**
* Class CuotasFPList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.CuotasFPList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('facturap.cuotas.index') );
        },
        model: app.Facturap2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class AcabadosProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosProductopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.acabados.index') );
        },
        model: app.Ordenp5Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class AreasProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasProductopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.areas.index') );
        },
        model: app.Ordenp6Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },

        validar: function( data ) {
            var error = { success: false, message: '' };

            // Validate exist
            if( !_.isNull(data.orden6_areap) && !_.isUndefined(data.orden6_areap) && data.orden6_areap != ''){
                var modelExits = _.find(this.models, function(item) {
                    return item.get('orden6_areap') == data.orden6_areap;
                });
            }else{
                var modelExits = _.find(this.models, function(item) {
                    return item.get('orden6_nombre') == data.orden6_nombre;
                });
            }

            if(modelExits instanceof Backbone.Model ) {
                error.message = 'El area que intenta ingresar ya existe.'
                return error;
            }

            error.success = true;
            return error;
        },

        total: function() {
            var _this = this;

            return this.reduce(function(sum, model){

                var func =  _this.convertirMinutos( model );
                return sum + func * parseFloat(model.get('orden6_valor'));

            }, 0);
        },

        totalRow: function( ){
            var _this = this;

            _.each( this.models, function(item) {

                var func = _this.convertirMinutos( item );
                var total = func * parseFloat(item.get('orden6_valor'));
                item.set('total', Math.round( total ));

            });
        },

        convertirMinutos: function ( model ){
            var tiempo = model.get('orden6_tiempo').split(':'),
                horas = parseInt( tiempo[0] ),
                minutos = parseInt( tiempo[1] );

            // Regla de 3 para convertir min a horas
            var total = horas + (minutos / 60);

            return parseFloat( total );
        },


        totalize: function(  ) {
            var total = this.total();
            this.totalRow();
            return { 'total': Math.round( total ) }
        },
   });

})(this, this.document);

/**
* Class ContabilidadOrdenpList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContabilidadOrdenpList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.contabilidad.index') );
        },
        model: app.TiempopModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class DespachospPendientesOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachospPendientesOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.despachos.pendientes') );
        },
        model: app.Ordenp2Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class DespachopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DespachopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.despachos.index') );
        },
        model: app.DespachopModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class MaquinasProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasProductopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.maquinas.index') );
        },
        model: app.Ordenp3Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class MaterialesProductopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesProductopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.materiales.index') );
        },
        model: app.Ordenp4Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class ProductopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.productos.index') );
        },
        model: app.Ordenp2Model,

        /**
        * Constructor Method
        */
        initialize : function(){

        },

        unidades: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('orden2_cantidad'))
            }, 0);
        },

        facturado: function() {
            return this.reduce(function(sum, model) {
                return sum + parseInt(model.get('orden2_facturado'))
            }, 0);
        },

        subtotal: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('orden2_precio_total'))
            }, 0);
        },

        totalize: function() {
            var unidades = this.unidades();
            var facturado = this.facturado();
            var subtotal = this.subtotal();
            return { 'unidades': unidades, 'facturado': facturado, 'subtotal': subtotal}
        },
   });

})(this, this.document);

/**
* Class TiempopOrdenList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempopOrdenList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('ordenes.tiemposp.index') );
        },
        model: app.TiempopModel,

        /**
        * Constructor Method
        */
        initialize : function(){

        }
   });

})(this, this.document);

/**
* Class ItemRolloINList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ItemRolloINList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.rollos.index') );
        },
        model: app.ItemRolloModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class ItemRolloINList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProdBodeList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.prodbode.index') );
        },
        model: app.ProdBodeModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class ProductoSeriesINList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ProductoSeriesINList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productos.index') );
        },
        model: app.ProductoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class AcabadosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AcabadosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.acabados.index') );
        },
        model: app.Productop6Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class AreasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AreasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.areas.index') );
        },
        model: app.Productop3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MaquinasList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaquinasList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.maquinas.index') );
        },
        model: app.Productop4Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class MaterialesList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.MaterialesList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.materiales.index') );
        },
        model: app.Productop5Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class TipsList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TipsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('productosp.tips.index') );
        },
        model: app.Productop2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class PermisosRolList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.PermisosRolList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('roles.permisos.index') );
        },
        model: app.ModuloModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class ContactsList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ContactsList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('terceros.contactos.index') );
        },
        model: app.ContactoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class FacturaptList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.FacturaptList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('terceros.facturap') );
        },
        model: app.Facturap2Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class RolList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.RolList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('terceros.roles.index') );
        },
        model: app.UsuarioRolModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class TiempopList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TiempopList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('tiemposp.index') );
        },
        model: app.TiempopModel,

        /**
        * Constructor Method
        */
        initialize : function(){
        }
   });

})(this, this.document);

/**
* Class TrasladoProductosList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.TrasladoProductosList = Backbone.Collection.extend({

        url: function() {
            return window.Misc.urlFull( Route.route('traslados.detalle.index') );
        },
        model: app.Traslado2Model,

        /**
        * Constructor Method
        */
        initialize : function() {

        }
   });

})(this, this.document);

/**
* Class CreateAcabadospView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAcabadospView = Backbone.View.extend({

        el: '#acabadosp-create',
        template: _.template( ($('#add-acabadop-tpl').html() || '') ),
        events: {
            'submit #form-acabadosp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-acabadop');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('acabadosp.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainAcabadospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAcabadospView = Backbone.View.extend({

        el: '#acabadosp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$acabadospSearchTable = this.$('#acabadosp-search-table');

            this.$acabadospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('acabadosp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'acabadop_nombre', name: 'acabadop_nombre' },
                    { data: 'acabadop_descripcion', name: 'acabadop_descripcion' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo acabado',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('acabadosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('acabadosp.show', {acabadosp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateActividadView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateActividadView = Backbone.View.extend({

        el: '#actividad-create',
        template: _.template( ($('#add-actividad-tpl').html() || '') ),
        events: {
            'submit #form-actividad': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-actividad');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSpinner == 'function' )
                window.initComponent.initSpinner();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('actividades.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainActividadView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActividadView = Backbone.View.extend({

        el: '#actividades-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$actividadesSearchTable = this.$('#actividades-search-table');

            this.$actividadesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('actividades.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'actividad_codigo', name: 'actividad_codigo' },
                    { data: 'actividad_nombre', name: 'actividad_nombre'},
                    { data: 'actividad_categoria', name: 'actividad_categoria'}, 
                    { data: 'actividad_tarifa', name: 'actividad_tarifa' }
                ],
                buttons: [
                    { 
                        text: '<i class="fa fa-user-plus"></i> Nueva actividad', 
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('actividades.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('actividades.show', {actividades: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateActividadpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateActividadpView = Backbone.View.extend({

        el: '#actividadp-create',
        template: _.template( ($('#add-actividadp-tpl').html() || '') ),
        events: {
            'submit #form-actividadp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-actividadp');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSpinner == 'function' )
                window.initComponent.initSpinner();

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

                window.Misc.redirect( window.Misc.urlFull( Route.route('actividadesp.index')) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainActividadespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainActividadespView = Backbone.View.extend({

        el: '#actividadesp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$actividadespSearchTable = this.$('#actividadesp-search-table');

            this.$actividadespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('actividadesp.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadp_nombre', name: 'actividadp_nombre'},
                    { data: 'actividadp_activo', name: 'actividadp_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nueva actividad',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('actividadesp.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('actividadesp.show', {actividadesp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateAreapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAreapView = Backbone.View.extend({

        el: '#areasp-create',
        template: _.template( ($('#add-areap-tpl').html() || '') ),
        events: {
            'submit #form-areasp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-areap');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('areasp.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainAreaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAreaspView = Backbone.View.extend({

        el: '#areasp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$areaspSearchTable = this.$('#areasp-search-table');

            this.$areaspSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('areasp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'areap_nombre', name: 'areap_nombre' },
                    { data: 'areap_valor', name: 'areap_valor'}
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva area',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('areasp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('areasp.show', {areasp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 2,
                        render: function ( data ) {
                            return window.Misc.currency( data );
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class AsientoActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoActionView = Backbone.View.extend({

        el: '#asiento-content',
        // Produccion
        templateOrdenp: _.template( ($('#searchordenp-asiento-tpl').html() || '') ),
        // Proveedores
        templateFacturap: _.template( ($('#rfacturap-asiento-tpl').html() || '') ),
        templateAddFacturap: _.template( ($('#add-rfacturap-asiento-tpl').html() || '') ),
        templateCuotasFacturap: _.template( ($('#add-rfacturap2-asiento-tpl').html() || '') ),
        // Cartera
        templateCartera: _.template( ($('#rcartera-asiento-tpl').html() || '') ),
        templateCommentsFactura: _.template( ($('#add-comments-tpl').html() || '') ),

        // Inventario
        templateInventario: _.template( ($('#add-inventario-asiento-tpl').html() || '') ),
        templateAddItemRollo: _.template( ($('#add-itemrollo-asiento-tpl').html() || '') ),
        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-asiento-tpl').html() || '') ),
        templateAddSeries: _.template( ($('#add-series-asiento-tpl').html() || '') ),
        events: {
            // Produccion
            'submit #form-create-ordenp-asiento-component-source': 'onStoreItemOrdenp',
            // Proveedores
            'submit #form-create-asiento-component-source': 'onStoreItemFacturap',
            'change input#facturap1_factura': 'facturapChanged',
            // Cartera
            'submit #form-create-cartera-component-source': 'onStoreItemFactura',
            'change .factura-koi-component': 'facturaChange',

            // Inventario
            'submit #form-create-inventario-asiento-component-source': 'onStoreItemInventario',
            'change .evaluate-producto-movimiento-asiento': 'evaluateProductoInventario'
        },
        parameters: {
            data: { },
            actions: { },
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalOp = this.$('#modal-asiento-ordenp-component');
            this.$modalFp = this.$('#modal-asiento-facturap-component');
            this.$modalIn = this.$('#modal-asiento-inventario-component');
            this.$modalCt = this.$('#modal-asiento-cartera-component');

            // Collection cuotas
            this.cuotasFPList = new app.CuotasFPList();
            // Collection item rollo
            this.itemRolloINList = new app.ItemRolloINList();
            // Collection series producto
            this.productoSeriesINList = new app.ProductoSeriesINList();
            // Collection pendientes factura
            this.detalleFactura4List = new app.DetalleFactura4List();

			// Events Listeners
            this.listenTo( this.cuotasFPList, 'reset', this.addAllCuotasFacturap );
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
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
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

		/**
        * Run actions
        */
        runAction: function( ) {
            var resp = this.evaluateNextAction(),
        		_this = this,
	            stuffToDo = {
	                'facturap' : function() {
	                    _this.$modalFp.find('.content-modal').empty().html( _this.templateFacturap( _this.parameters.data ) );

	                    // Reference facturap
	                   	_this.referenceFacturap();

	                },

                    'cartera' : function() {
                        _this.$modalCt.find('.content-modal').empty().html( _this.templateCartera( _this.parameters.data ) );

                        // Reference cartera
                        _this.referenceCartera();
                    },

	                'ordenp' : function() {
                        _this.$modalOp.find('.content-modal').empty().html( _this.templateOrdenp( _this.parameters.data ) );
                        // Reference ordenp
                        _this.referenceOrdenp();
                    },

                    'inventario' : function() {
                        _this.$modalIn.find('.content-modal').empty().html( _this.templateInventario( _this.parameters.data ) );
	                 	// Reference inventario
	            		_this.referenceInventario();
	                },

	                'store' : function() {
                        _this.onStoreItem();
	                }
	            };

            if (stuffToDo[resp.action]) {
                stuffToDo[resp.action]();
            }
        },

        /**
        * Evaluate first action account
        */
        evaluateNextAction: function() {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                action = this.parameters.actions[index];

                if(action.success == false) {
                    return action;
                }
            }

            return { action :'store' };
        },

        /**
        * Set success action
        */
        setSuccessAction: function(action) {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if(item.action == action) {
                    item.success = true;
                }
            }
        },

        /**
        * is last action
        */
        isLastAction: function(action) {
            var index;
            for (index = this.parameters.actions.length - 1; index >= 0; --index) {
                item = this.parameters.actions[index];

                if(item.success == false && item.action != action) {
                    return false;
                }
            }
            return true;
        },

        /**
        * Validate action item asiento2 (facturap, ordenp, inventario, cartera)
        */
        validateAction: function ( options ) {

            options || (options = {});

            var defaults = {
                    'callback': null,
                    'action': null
                },
                data = {},
                settings = {}
                _this = this;

            settings = $.extend({}, defaults, options);

            // Prepare global data
            data.action = settings.action;
            data = $.extend({}, this.parameters.data, data);

            // Prepare global route
            _this.url = window.Misc.urlFull(Route.route('asientos.detalle.validate'));

            if (_.has(data, "plancuentasn_cuenta"))
                _this.url = window.Misc.urlFull(Route.route('asientosnif.detalle.validate'));

            // Validate action
            $.ajax({
                url: _this.url,
                type: 'POST',
                data: data,
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraper );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraper );

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

                    // return callback
                    if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                        settings.callback( resp );
                }

            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Reference facturap
        */
        referenceFacturap: function( ) {
        	var _this = this;

            this.$wraper = this.$('#modal-asiento-wrapper-facturap');
            this.$wraperFormFp = this.$('#content-invoice');
            this.$wraperErrorFp = this.$('#error-eval-facturap');

            // Hide errors
            this.$wraperErrorFp.hide().empty();

            // Open modal
            this.$modalFp.modal('show');
        },

        /**
        * Reference cartera
        */
        referenceCartera: function( ) {
            var _this = this;

            this.$wraper = this.$('#modal-asiento-wrapper-cartera');
            this.$wraperFormCt = this.$('#content-cartera');
            this.$wraperErrorCt = this.$('#error-eval-cartera');

            // Hide errors
            this.$wraperErrorCt.hide().empty();

            // Open modal
            this.$modalCt.modal('show');
        },


        /**
        * Reference orden
        */
        referenceOrdenp: function( ) {
            var _this = this;

            this.$wraper = this.$('#modal-asiento-wrapper-ordenp');
            this.$wraperFormOp = this.$modalOp.find('.content-modal');
            this.$wraperErrorOp = this.$('#error-search-orden-asiento2');

            // Hide errors
            this.$wraperErrorOp.hide().empty();

            // Open modal
            this.$modalOp.modal('show');
        },

        /**
        * Reference inventario
        */
        referenceInventario: function( ) {
            var _this = this;

            this.$wraper = this.$('#modal-asiento-wrapper-inventario');
            this.$wraperFormIn = this.$modalIn.find('.content-modal');
            this.$wraperDetailIn = this.$modalIn.find('#content-detail-inventory');
            this.$wraperErrorIn = this.$('#error-inventario-asiento2');

            this.$inputInProducto = this.$('#producto_codigo');
            this.$inputInUnidades = this.$('#movimiento_cantidad');
            this.$inputInSucursal = this.$('#movimiento_sucursal');

            // Hide errors
            this.$wraperErrorIn.hide().empty();

            // Open modal
            this.$modalIn.modal('show');
        },

        /**
        * Event add item ordenp
        */
        onStoreItemOrdenp: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Evaluate account
                this.validateAction({
                    'action': 'ordenp',
                    'callback': (function (_this) {
                        return function ( resp )
                        {
                            if(resp.success) {
                                // Set action success
                                _this.setSuccessAction('ordenp', _this.parameters.actions);

                                if( !_this.isLastAction('ordenp') ){
                                    // Close modal
                                    _this.$modalOp.modal('hide');
                                }
                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /*
        * Facturap changed
        */
        facturapChanged: function(e) {
        	// Hide errors
            this.$wraperErrorFp.hide().empty();
            // Empty Form
            this.$wraperFormFp.empty();

            // Evaluate account
            window.Misc.evaluateFacturap({
                'facturap': $(e.currentTarget).val(),
                'naturaleza': this.parameters.data.asiento2_naturaleza,
                'tercero': this.parameters.data.tercero_nit,
                'wrap': this.$wraperFormFp,
                'callback': (function (_this) {
                    return function ( resp )
                    {
                        if(resp.actions) {
                            // stuffToDo Response success
                            var stuffToDo = {
                                'add' : function() {
                                    // AddFacturapView
                                    _this.$wraperFormFp.html( _this.templateAddFacturap( ) );
                                    _this.ready();
                                },
                                'quota' : function() {
                                    // QuotaFacturapView
                                    _this.$wraperFormFp.html( _this.templateCuotasFacturap( ) );
                                    _this.$wraperCuotasFp = _this.$('#browse-rfacturap2-list');

                                    // Get cuotas list
                                    _this.cuotasFPList.fetch({ reset: true, data: { facturap1: resp.facturap } });
                                }
                            };

                            if (stuffToDo[resp.action]) {
                                stuffToDo[resp.action]();
                            }

                        }else{
                            // No actions
                            if(!_.isUndefined(resp.message) && !_.isNull(resp.message) && resp.message != '') {
                                _this.$wraperErrorFp.empty().append(resp.message);
                                _this.$wraperErrorFp.show();
                            }
                        }
                    }
                })(this)
            });
        },

        /**
        * Render view task by model
        * @param Object Facturap2Model Model instance
        */
        addOneCuotaFacturap: function (Facturap2Model) {
            var view = new app.CuotasFPListView({
                model: Facturap2Model
            });

            this.$wraperCuotasFp.append( view.render().el );

            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllCuotasFacturap: function () {
            this.cuotasFPList.forEach( this.addOneCuotaFacturap, this );
        },

        /**
        * Event add item facturap
        */
        onStoreItemFacturap: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Evaluate account
                this.validateAction({
                    'action': 'facturap',
                    'callback': (function (_this) {
                        return function ( resp )
                        {
                            if(resp.success) {
                                // Set action success
                                _this.setSuccessAction('facturap', _this.parameters.actions);

                                if( !_this.isLastAction('facturap') ){
                                    // Close modal
                                    _this.$modalFp.modal('hide');
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (ItemRolloModel, choose) {
            choose || (choose = false);

            var view = new app.ItemRolloINListView({
                model: ItemRolloModel,
                parameters: {
                    choose: choose

                }
            });

            this.$wraperItemRollo.append( view.render().el );

            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllItemRolloInventario: function () {
            var _this = this;
            this.itemRolloINList.forEach(function(model, index) {
                _this.addOneItemRolloInventario(model, true)
            });
        },

        /**
        * Render view task by model
        * @param Object Producto Model instance
        */
        addOneSerieInventario: function (ProductoModel) {
            var view = new app.ProductoSeriesINListView({
                model: ProductoModel
            });

            this.$wraperSeries.append( view.render().el );

            this.ready();
        },

        /*
        * Evaluar producto inventario
        */
        evaluateProductoInventario: function(e) {
            var _this = this,
                producto = this.$inputInProducto.val(),
                sucursal = this.$inputInSucursal.val(),
                unidades = this.$inputInUnidades.val();

            // Empty wrapper detail
            this.$wraperDetailIn.empty();

            if(producto && sucursal && unidades)
            {
                // Search producto
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productos.search') ),
                    type: 'GET',
                    data: { producto_codigo: producto },
                    beforeSend: function() {
                        _this.$wraperErrorIn.hide().empty();
                        window.Misc.setSpinner( _this.$wraperFormIn );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperFormIn );

                    if(resp.success) {
                        if( !parseInt(resp.producto_unidades) ) {
                            // Unidades
                            _this.$wraperErrorIn.empty().append( 'No es posible realizar movimientos para productos que no manejan unidades' );
                            _this.$wraperErrorIn.show();
                            return;

                        }else if( parseInt(resp.producto_metrado) ){
                            // Metrado
                            if(_this.parameters.data.asiento2_naturaleza == 'D') {
                                // Items rollo view
                                _this.$wraperDetailIn.html( _this.templateAddItemRollo( ) );
                                _this.$wraperItemRollo = _this.$('#browse-itemtollo-list');

                                var item = 1;
                                for (; item <= unidades; item++) {
                                    _this.addOneItemRolloInventario( new app.ItemRolloModel({ id: item }) )
                                }

                            }else{
                                // Items rollo view
                                _this.$wraperDetailIn.html( _this.templateChooseItemsRollo( ) );
                                _this.$wraperItemRollo = _this.$('#browse-chooseitemtollo-list');

                                // Get item rollo list
                                _this.itemRolloINList.fetch({ reset: true, data: { producto: resp.id, sucursal: sucursal } });
                            }
                        }else if( parseInt(resp.producto_serie) ){
                            // Series
                            if(_this.parameters.data.asiento2_naturaleza == 'D') {
                                // Items series view
                                _this.$wraperDetailIn.html( _this.templateAddSeries( ) );
                                _this.$wraperSeries = _this.$('#browse-series-list');

                                var item = 1;
                                for (; item <= unidades; item++) {
                                    _this.addOneSerieInventario( new app.ProductoModel({ id: item }) )
                                }

                            }
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    _this.$wraperErrorIn.empty().append( thrownError );
                    _this.$wraperErrorIn.show();
                });
            }
        },

        /**
        * Event add item inventario
        */
        onStoreItemInventario: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Evaluate account
                this.validateAction({
                    'action': 'inventario',
                    'callback': (function (_this) {
                        return function ( resp )
                        {
                            if(resp.success) {
                                // Set action success
                                _this.setSuccessAction('inventario', _this.parameters.actions);

                                if( !_this.isLastAction('inventario') ){
                                    // Close modal
                                    _this.$modalIn.modal('hide');
                                }

                                // Inventario modifica valor item asiento por el valor del costo del movimiento
                                if(!_.isUndefined(resp.asiento2_valor) && !_.isNull(resp.asiento2_valor) && resp.asiento2_valor != _this.parameters.data.asiento2_valor) {
                                    _this.parameters.data.asiento2_valor = resp.asiento2_valor;
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Event add item cartera
        */
        onStoreItemFactura: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Extend attributes
                this.parameters.data = $.extend({}, this.parameters.data, window.Misc.formToJson( e.target ));

                // Evaluate account
                this.validateAction({
                    'action': 'cartera',
                    'callback': (function (_this) {
                        return function ( resp )
                        {
                            if(resp.success) {
                                // Set action success
                                _this.setSuccessAction('cartera', _this.parameters.actions);

                                if( !_this.isLastAction('cartera') ){
                                    // Close modal
                                    _this.$modalCt.modal('hide');
                                }

                                // Next action
                                _this.runAction();
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        *   Change Factura Exists Cartera
        */
        facturaChange: function(e) {
            var factura1_id = this.$('#factura1_referencia').val();
            this.$('#wrapper-table-factura').removeAttr('hidden');

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFactura4List,
                parameters: {
                    edit: false,
                    template: _.template( ($('#factura-item-list-tpl').html() || '') ),
                    call: 'asiento',
                    dataFilter: {
                        factura1_id: factura1_id
                    }
                }
            });
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            // Model exist
            if( this.model.id != undefined ) {
                // Insert item
                this.collection.trigger( 'store', this.parameters.data );
            }else{
                // Create model
                this.model.save( this.parameters.data, {patch: true, silent: true} );
            }
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {

                    // Close modals
                    this.$modalOp.modal('hide');
                    this.$modalIn.modal('hide');
                    this.$modalFp.modal('hide');
                    this.$modalCt.modal('hide');

                    window.Misc.clearForm( $('#form-item-asiento') );
                }
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class AsientoCuentasListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasListView = Backbone.View.extend({

        el: '#browse-detalle-asiento-list',
        events: {
            'click .item-asiento2-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$debitos = this.$('#total-debitos');
            this.$creditos = this.$('#total-creditos');
            this.$diferencia = this.$('#total-diferencia');

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            /* if was passed asiento code */
            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                 this.confCollection.data = this.parameters.dataFilter;

                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (Asiento2Model) {
            var view = new app.AsientoCuentasItemView({
                model: Asiento2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            Asiento2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var asiento2Model = new app.Asiento2Model();
            asiento2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            // Function confirm delete item
            this.confirmDelete( model );
        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { plancuentas_cuenta: model.get('plancuentas_cuenta'), plancuentas_nombre: model.get('plancuentas_nombre') },
                    template: _.template( ($('#asiento-item-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar cuenta',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);

                                        // Update total
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Render totalize debitos and creditos
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$debitos.length) {
                this.$debitos.html( window.Misc.currency(data.debitos) );
            }

            if(this.$creditos.length) {
                this.$creditos.html( window.Misc.currency(data.creditos) );
            }

            if(this.$diferencia.length) {
                this.$diferencia.html( window.Misc.currency(data.diferencia) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class AsientoCuentasItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-asiento2-item-tpl').html() || '') ),
        templateInfo: _.template( ($('#show-info-asiento2-tpl').html() || '') ),

        // Factura
        templateInfoFacturaItem: _.template( ($('#add-info-factura-item').html() || '') ),
        // Facturap
        templateInfoFacturapItem: _.template( ($('#add-info-facturap-item').html() || '') ),
        // Inventario
        templateInfoInventarioItem: _.template( ($('#add-info-inventario-item').html() || '') ),

        events: {
            'click .item-asiento2-show-info': 'showInfo'
        },
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.$modalInfo = $('#modal-asiento-show-info-component');
            this.asientoMovimientosList = new app.AsientoMovimientosList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );

            this.listenTo( this.asientoMovimientosList, 'request', this.loadSpinner );
            this.listenTo( this.asientoMovimientosList, 'sync', this.responseServer );
            this.listenTo( this.asientoMovimientosList, 'reset', this.addAll );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;

            this.$tercero = {
                tercero_nit: attributes.tercero_nit,
                tercero_nombre: attributes.tercero_nombre
            };
            this.$naturaleza = attributes.asiento2_naturaleza;

            this.$el.html( this.template(attributes) );
            return this;
        },
        /**
        * Show info asiento
        */
        showInfo: function () {
            var attributes = this.model.toJSON();

            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );

            // Wrapper Info
            this.$wrapGeneral = this.$modalInfo.find('#render-info-modal');

            // Get movimientos list
            this.asientoMovimientosList.fetch({ reset: true, data: { asiento2: this.model.get('id') } });

            // Open modal
            this.$modalInfo.modal('show');
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (AsientoMovModel) {
            var attributes = AsientoMovModel.toJSON();
                attributes.tercero = this.$tercero;
                attributes.naturaleza = this.$naturaleza;

            // SI Tipo es factura
            if( attributes.type == 'F'){
                this.$wrapGeneral.empty().html(  this.templateInfoFacturaItem( attributes ) );
            }else if( attributes.type == 'FP'){
                this.$wrapGeneral.empty().html(  this.templateInfoFacturapItem( attributes ) );
            }else if ( attributes.type == 'IP') {
                this.$wrapGeneral.empty().html(  this.templateInfoInventarioItem( attributes ) );
            }
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.asientoMovimientosList.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wrapperList );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wrapperList );
        }
    });
})(jQuery, this, this.document);

/**
* Class CreateAsientoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateAsientoView = Backbone.View.extend({

        el: '#asientos-create',
        template: _.template( ($('#add-asiento-tpl').html() || '') ),
        events: {
            'change select#asiento1_documento': 'documentoChanged',
            'change input#asiento2_base': 'baseChanged',
            'submit #form-asientos': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            var attributes = this.model.toJSON();
                attributes.edit = false;
            this.$el.html( this.template(attributes) );

            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");
            this.spinner = this.$('#spinner-main');

            // Events listener
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            // to fire plugins
            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        documentoChanged: function(e) {
            var _this = this,
                documento = $(e.currentTarget).val();

            // Clear numero
            _this.$numero.val('');

            if(!_.isUndefined(documento) && !_.isNull(documento) && documento != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('documentos.show', { documentos: documento })),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    if( _.isObject( resp ) ) {
                        if(!_.isUndefined(resp.documento_tipo_consecutivo) && !_.isNull(resp.documento_tipo_consecutivo)) {
                            _this.$numero.val(resp.documento_consecutivo + 1);
                            if(resp.documento_tipo_consecutivo == 'M') {
                                _this.$numero.prop('readonly', false);
                            }else if (resp.documento_tipo_consecutivo == 'A'){
                                _this.$numero.prop('readonly', true);
                            }
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );

                // Definir tercero
                data.tercero_nit = data.tercero_nit ? data.tercero_nit : data.asiento1_beneficiario;
                data.tercero_nombre = data.tercero_nombre ? data.tercero_nombre : data.asiento1_beneficiario_nombre;

                window.Misc.evaluateActionsAccount({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function ( actions )
                        {
                            if( Array.isArray( actions ) && actions.length > 0 ) {
                                // Open AsientoActionView
                                if ( _this.asientoActionView instanceof Backbone.View ){
                                    _this.asientoActionView.stopListening();
                                    _this.asientoActionView.undelegateEvents();
                                }

                                _this.asientoActionView = new app.AsientoActionView({
                                    model: _this.model,
                                    collection: _this.asientoCuentasList,
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            }else{
                                // Default insert
                                _this.model.save( data, {patch: true, silent: true} );
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Change base
        */
        baseChanged: function(e) {
            var _this = this;

            var tasa = this.$inputTasa.val();
            var base = this.$inputBase.inputmask('unmaskedvalue');

            // Set valor
            if(!_.isUndefined(tasa) && !_.isNull(tasa) && tasa > 0) {
                this.$inputValor.val( (tasa * base) / 100 );
            }else{
                // Case without plancuentas_tasa
                this.$inputValor.val('');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // AsientoActionView undelegateEvents
                if ( this.asientoActionView instanceof Backbone.View ){
                    this.asientoActionView.stopListening();
                    this.asientoActionView.undelegateEvents();
                }

                if ( resp.id == '' && resp.nif != '' ) {
                    // Redirect to Content Course
                    window.Misc.redirect( window.Misc.urlFull( Route.route('asientosnif.edit', { asientosnif: resp.nif}), { trigger:true }));

                }else{
                    // Redirect to Content Course
                    Backbone.history.navigate(Route.route('asientos.edit', { asientos: resp.id}), { trigger:true });
                }
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class EditAsientoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditAsientoView = Backbone.View.extend({

        el: '#asientos-create',
        template: _.template( ($('#add-asiento-tpl').html() || '') ),
        events: {
            'change select#asiento1_documento': 'documentoChanged',
            'submit #form-item-asiento': 'onStoreItem',
            'change input#asiento2_base': 'baseChanged',
            'click .submit-asiento': 'submitAsiento',
            'submit #form-asientos': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.asientoCuentasList = new app.AsientoCuentasList();

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            // Attributes
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$numero = this.$('#asiento1_numero');
            this.$form = this.$('#form-asientos');
            this.$formItem = this.$('#form-item-asiento');
            this.$inputTasa = this.$("#asiento2_tasa");
            this.$inputValor = this.$("#asiento2_valor");
            this.$inputBase = this.$("#asiento2_base");
            this.$inputDocumento = this.$("#asiento1_documento");
            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

            // to fire plugins
            this.ready();

            // to change document
            if(this.model.get('documento_tipo_consecutivo') == 'A'){
                this.$inputDocumento.change();
            }
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        },

        documentoChanged: function(e) {
            var _this = this,
                documento = $(e.currentTarget).val();

            // Clear numero
            _this.$numero.val('');

            if(!_.isUndefined(documento) && !_.isNull(documento) && documento != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('documentos.show', { documentos: documento })),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    if( _.isObject( resp ) ) {
                        if(!_.isUndefined(resp.documento_tipo_consecutivo) && !_.isNull(resp.documento_tipo_consecutivo)) {
                            _this.$numero.val(resp.documento_consecutivo + 1);
                            if(resp.documento_tipo_consecutivo == 'M') {
                                _this.$numero.prop('readonly', false);
                            }else if (resp.documento_tipo_consecutivo == 'A'){
                                _this.$numero.prop('readonly', true);
                            }
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event submit Asiento
        */
        submitAsiento: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                data.asiento1_id = this.model.get('id');

                // Definir tercero
                data.tercero_nit = data.tercero_nit ? data.tercero_nit : this.model.get('tercero_nit');
                data.tercero_nombre = data.tercero_nombre ? data.tercero_nombre : this.model.get('tercero_nombre');

                // Evaluate account
                window.Misc.evaluateActionsAccount({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function ( actions )
                        {
                            if( Array.isArray( actions ) && actions.length > 0 ) {
                                // Open AsientoActionView
                                if ( _this.asientoActionView instanceof Backbone.View ){
                                    _this.asientoActionView.stopListening();
                                    _this.asientoActionView.undelegateEvents();
                                }

                                _this.asientoActionView = new app.AsientoActionView({
                                    model: _this.model,
                                    collection: _this.asientoCuentasList,
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            }else{
                                // Default insert
                                _this.asientoCuentasList.trigger( 'store', data );
                                window.Misc.clearForm( _this.$formItem );
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Change base
        */
        baseChanged: function(e) {
            var _this = this;

            var tasa = this.$inputTasa.val();
            var base = this.$inputBase.inputmask('unmaskedvalue');

            // Set valor
            if(!_.isUndefined(tasa) && !_.isNull(tasa) && tasa > 0) {
                this.$inputValor.val( (tasa * base) / 100 );
            }else{
                // Case without plancuentas_tasa
                this.$inputValor.val('');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to show view
                window.Misc.redirect( window.Misc.urlFull( Route.route('asientos.edit', { asientos: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class CuotasFPListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CuotasFPListView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-rfacturap2-item-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function() {
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class MainAsientosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAsientosView = Backbone.View.extend({

        el: '#asientos-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;
            this.$asientosSearchTable = this.$('#asientos-search-table');

            // References
            this.$searchTercero = this.$('#search_tercero');
            this.$searchTerceroName = this.$('#search_tercero_nombre');
            this.$searchReferencia = this.$('#search_referencia');
            this.$searchDocumento = this.$('#search_documento');

            this.asientosSearchTable = this.$asientosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('asientos.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.asiento_tercero_nit = _this.$searchTercero.val();
                        data.asiento_tercero_nombre = _this.$searchTerceroName.val();
                        data.asiento_documento = _this.$searchDocumento.val();
                    }
                },
                columns: [
                    { data: 'asiento1_numero', name: 'asiento1_numero' },
                    { data: 'documento_nombre', name: 'documento_nombre' },
                    { data: 'asiento1_ano', name: 'asiento1_ano' },
                    { data: 'asiento1_mes', name: 'asiento1_mes' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'asiento1_preguardado', name: 'asiento1_preguardado' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nueva asiento',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('asientos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '7%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.asiento1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.edit', {asientos: full.id }) )  +'">' + data + ' <span class="label label-warning">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientos.show', {asientos: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: [2, 3],
                        width: '7%'
                    },
                    {
                        targets: 4,
                        width: '15%'
                    },
                    {
                        targets: 5,
                        searchable: false
                    },
                    {
                        targets: [6, 7, 8, 9, 10],
                        visible: false
                    },
                    {
                        targets: 11,
                        visible: false,
                        searchable: false
                    }
                ],
                order: [
                	[ 2, 'desc' ], [ 3, 'desc' ]
                ],
			});
        },

        search: function(e) {
            e.preventDefault();

            this.asientosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            // References
            this.$searchTercero.val('');
            this.$searchTerceroName.val('');
            this.$searchReferencia.val('');
            this.$searchDocumento.val('').trigger('change');

            this.asientosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class ProductoSeriesINListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductoSeriesINListView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-serie-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function() {
            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class ShowAsientoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAsientoView = Backbone.View.extend({

        el: '#asientos-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.asientoCuentasList = new app.AsientoCuentasList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.el,
                    dataFilter: {
                        asiento: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class AsientoCuentasNifListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoNifCuentasListView = Backbone.View.extend({

        el: '#browse-detalle-asienton-list',
        events: {
            'click .item-asienton2-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$debitos = this.$('#total-debitos');
            this.$creditos = this.$('#total-creditos');
            this.$diferencia = this.$('#total-diferencia');

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            /* if was passed asiento code */
            if( !_.isUndefined(this.parameters.dataFilter.asiento) && !_.isNull(this.parameters.dataFilter.asiento) ){
                 this.confCollection.data.asiento = this.parameters.dataFilter.asiento;

                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (asientoNif2Model) {
            var view = new app.AsientoCuentasNifItemView({
                model: asientoNif2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            asientoNif2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var asiento2Model = new app.AsientoNif2Model();
            asiento2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                            _this.collection.remove(model);

                            // Update total
                            _this.totalize();
                        }
                    }
                });

            }
        },

        /**
        * Render totalize debitos and creditos
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$debitos.length) {
                this.$debitos.html( window.Misc.currency(data.debitos) );
            }

            if(this.$creditos.length) {
                this.$creditos.html( window.Misc.currency(data.creditos) );
            }

            if(this.$diferencia.length) {
                this.$diferencia.html( window.Misc.currency(data.diferencia) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class AsientoCuentasNifItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AsientoCuentasNifItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-asienton2-item-tpl').html() || '') ),
        templateInfo: _.template( ($('#show-info-asienton2-tpl').html() || '') ),

        // Factura
        templateInfoFacturaItem: _.template( ($('#add-info-factura-item').html() || '') ),
        // Facturap
        templateInfoFacturapItem: _.template( ($('#add-info-facturap-item').html() || '') ),
        // Inventario
        templateInfoInventarioItem: _.template( ($('#add-info-inventario-item').html() || '') ),

        events: {
            'click .item-asiento2-show-info': 'showInfo'
        },
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.$modalInfo = $('#modal-asiento-show-info-component');
            this.asientoMovimientosList = new app.AsientoMovimientosList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );

            this.listenTo( this.asientoMovimientosList, 'request', this.loadSpinner );
            this.listenTo( this.asientoMovimientosList, 'sync', this.responseServer );
            this.listenTo( this.asientoMovimientosList, 'reset', this.addAll );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$tercero = {tercero_nit: attributes.tercero_nit, tercero_nombre: attributes.tercero_nombre};
            this.$naturaleza = attributes.asiento2_naturaleza;

            this.$el.html( this.template(attributes) );
            return this;
        },

        /**
        * Show info asiento
        */
        showInfo: function () {
            var attributes = this.model.toJSON();

            // Render info
            this.$modalInfo.find('.content-modal').empty().html( this.templateInfo( attributes ) );

            // Wrapper Info
            this.$wrapGeneral = this.$modalInfo.find('#render-info-modal');

            // Count
            this.count = 0;

            // Get movimientos list
            this.asientoMovimientosList.fetch({ reset: true, data: { asiento2: this.model.get('id') } });

            // Open modal
            this.$modalInfo.modal('show');
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (AsientoMovModel) {
            var attributes = AsientoMovModel.toJSON();
                attributes.tercero = this.$tercero;
                attributes.naturaleza = this.$naturaleza;


            if( attributes.movimiento_tipo == 'F'){

                this.$wrapGeneral.empty().html(  this.templateInfoFacturaItem( attributes ) );
                this.$wrapperList = this.$modalInfo.find('#browse-showinfo-factura-list');

            }else if ( attributes.movimiento_tipo == 'FP' ){

                if (attributes.movimiento_nuevo){
                    this.$wrapGeneral.empty().html(  this.templateInfoFacturapItem( attributes ) );
                    return;
                }else{
                    if ( this.count == 0){
                        this.$wrapGeneral.empty().html(  this.templateInfoFacturapItem( attributes ) );
                        this.$wrapperList = this.$modalInfo.find('#browse-showinfo-facturap-list');
                        this.count = this.count + 1;
                    }
                }

            }else if ( attributes.movimiento_tipo == 'IP') {

                this.$wrapGeneral.empty().html(  this.templateInfoInventarioItem( attributes ) );
                this.$wrapperList = this.$modalInfo.find('#browse-showinfo-asiento-list');
                
            }
            
            var view = new app.AsientoMovimientosItemView({
                model: AsientoMovModel,
            });

            this.$wrapperList.append( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.asientoMovimientosList.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wrapperList );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wrapperList );
        }
    });

})(jQuery, this, this.document);
/**
* Class EditAsientoNifView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditAsientoNifView = Backbone.View.extend({

        el: '#asientosnif-create',
        template: _.template( ($('#add-asienton-tpl').html() || '') ),
        templateFp: _.template( ($('#add-rfacturap-tpl').html() || '') ),
        events: {
            'change select#asienton1_documento': 'documentoChanged',
            'submit #form-item-asienton': 'onStoreItem',
            'change input#asienton2_base': 'baseChanged',
            'click .submit-asienton': 'submitAsiento',
            'submit #form-asientosn': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.asientoNifCuentasList = new app.AsientoNifCuentasList();

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$numero = this.$('#asienton1_numero');
            this.$form = this.$('#form-asientosn');
            this.$formItem = this.$('#form-item-asienton');
            this.$inputTasa = this.$("#asienton2_tasa");
            this.$inputValor = this.$("#asienton2_valor");
            this.$inputBase = this.$("#asienton2_base");
            this.$inputDocumento = this.$("#asienton1_documento");
            this.spinner = this.$('#spinner-main');

            // Reference views
            this.referenceViews();

            // to fire plugins
            this.ready();

            // to change document
            if(this.model.get('documento_tipo_consecutivo') == 'A'){
                this.$inputDocumento.change();
            }
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoNifCuentasListView({
                collection: this.asientoNifCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: true,
                    dataFilter: {
                        'asiento': this.model.get('id')
                    }
                }
            });
        },

        documentoChanged: function(e) {
            var _this = this,
                documento = $(e.currentTarget).val();

            // Clear numero
            _this.$numero.val('');

            if(!_.isUndefined(documento) && !_.isNull(documento) && documento != '') {
                $.ajax({
                    url: window.Misc.urlFull(Route.route('documentos.show', { documentos: documento })),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );
                    if( _.isObject( resp ) ) {
                        if(!_.isUndefined(resp.documento_tipo_consecutivo) && !_.isNull(resp.documento_tipo_consecutivo)) {
                            _this.$numero.val(resp.documento_consecutivo + 1);
                            if(resp.documento_tipo_consecutivo == 'M') {
                                _this.$numero.prop('readonly', false);
                            }else if (resp.documento_tipo_consecutivo == 'A'){
                                _this.$numero.prop('readonly', true);
                            }
                        }
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * Event submit Asiento
        */
        submitAsiento: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item Asiento Cuentas
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                data.asienton1_id = this.model.get('id');

                // Definir tercero
                data.tercero_nit = data.tercero_nit ? data.tercero_nit : this.model.get('tercero_nit');
                data.tercero_nombre = data.tercero_nombre ? data.tercero_nombre : this.model.get('tercero_nombre');

                // Default insert
                    // this.asientoNifCuentasList.trigger( 'store', data );
                    // window.Misc.clearForm( this.$formItem );  
                // Evaluate account
                window.Misc.evaluateActionsAccountNif({
                    'data': data,
                    'wrap': this.spinner,
                    'callback': (function (_this) {
                        return function ( actions )
                        {
                            if( Array.isArray( actions ) && actions.length > 0 ) {
                                // Open AsientoActionView
                                if ( _this.asientoActionView instanceof Backbone.View ){
                                    _this.asientoActionView.stopListening();
                                    _this.asientoActionView.undelegateEvents();
                                }

                                _this.asientoActionView = new app.AsientoActionView({
                                    model: _this.model,
                                    collection: _this.asientoNifCuentasList,
                                    parameters: {
                                        data: data,
                                        actions: actions
                                    }
                                });
                                _this.asientoActionView.render();
                            }else{
                                // Default insert
                                _this.asientoNifCuentasList.trigger( 'store', data );
                                window.Misc.clearForm( _this.$formItem );   
                            }
                        }
                    })(this)
                });
            }
        },

        /**
        * Change base
        */
        baseChanged: function(e) {
            var _this = this;

            var tasa = this.$inputTasa.val();
            var base = this.$inputBase.inputmask('unmaskedvalue');

            // Set valor
            if(!_.isUndefined(tasa) && !_.isNull(tasa) && tasa > 0) {
                this.$inputValor.val( (tasa * base) / 100 );
            }else{
                // Case without plancuentas_tasa
                this.$inputValor.val('');
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to show view
                window.Misc.redirect( window.Misc.urlFull( Route.route('asientosnif.edit', { asientosnif: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainAsientosNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAsientosNifView = Backbone.View.extend({

        el: '#asientosnif-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$asientosNifSearchTable = this.$('#asientosnif-search-table');

            this.$asientosNifSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('asientosnif.index') ),
                columns: [
                    { data: 'asienton1_numero', name: 'asienton1_numero' },
                    { data: 'asienton1_ano', name: 'asienton1_ano' },
                    { data: 'asienton1_mes', name: 'asienton1_mes' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' },
                    { data: 'asienton1_preguardado', name: 'asienton1_preguardado' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if( parseInt(full.asienton1_preguardado) ) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientosnif.edit', {asientosnif: full.id }) )  +'">' + data + ' <span class="label label-warning">PRE</span></a>';
                            }else{
                                return '<a href="'+ window.Misc.urlFull( Route.route('asientosnif.show', {asientosnif: full.id }) )  +'">' + data + '</a>';
                            }
                        }
                    },
                    {
                        targets: [1, 2],
                        width: '10%'
                    },
                    {
                        targets: 3,
                        width: '15%'
                    },
                    {
                        targets: 4,
                        searchable: false
                    },
                    {
                        targets: [5, 6, 7, 8, 9],
                        visible: false
                    },
                    {
                        targets: 10,
                        visible: false,
                        searchable: false
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class ShowAsientoNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowAsientoNifView = Backbone.View.extend({

        el: '#asientosnif-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {
             
                this.asientoNifCuentasList = new app.AsientoNifCuentasList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle asiento list
            this.cuentasListView = new app.AsientoNifCuentasListView({
                collection: this.asientoNifCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        'asiento': this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateCentroCostoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCentroCostoView = Backbone.View.extend({

        el: '#centrocosto-create',
        template: _.template( ($('#add-centrocosto-tpl').html() || '') ),
        events: {
            'submit #form-centrocosto': 'onStore'
        },
        parameters: {
            callback : ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.msgSuccess = 'Centro de costo guardado con exito!';
            this.$wraperForm = this.$('#render-form-centrocosto');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                // stuffToDo Callback
                var _this = this,
                    stuffToDo = {
                        'toShow' : function() {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('centroscosto.index') ) );            
                        },

                        'default' : function() {
                            alertify.success(_this.msgSuccess);
                        }
                    };

                if (stuffToDo[this.parameters.callback]) {
                    stuffToDo[this.parameters.callback]();
                } else {
                    stuffToDo['default']();
                }
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainCentrosCostoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCentrosCostoView = Backbone.View.extend({

        el: '#centroscosto-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$centroscostoSearchTable = this.$('#centroscosto-search-table');

            this.$centroscostoSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('centroscosto.index') ),
                columns: [
                    { data: 'centrocosto_codigo', name: 'centrocosto_codigo' },
                    { data: 'centrocosto_centro', name: 'centrocosto_centro' },
                    { data: 'centrocosto_nombre', name: 'centrocosto_nombre' },
                    { data: 'centrocosto_estructura', name: 'centrocosto_estructura' },
                    { data: 'centrocosto_activo', name: 'centrocosto_activo' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo centro de costo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('centroscosto.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('centroscosto.show', {centroscosto: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data == 'S' ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: [4],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class ComponentAddressView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentAddressView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-address-component-tpl').html() || '') ),
        templateSelect: _.template( ($('#koi-component-select-tpl').html() || '') ),
		events: {
        	'focus input.address-koi-component': 'addressChanged',
            'click .btn-address-koi-component': 'focusComponent',
            'submit #form-address-component': 'addAddress',
            'change #component-select': 'ChangeSelect',
            'click .koi-component-remove-last': 'removeLastItem',
            'click .koi-component-remove': 'removeItem',
            'click .koi-component-add': 'listeningAddress'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            // Initialize
            this.$modalComponent = this.$('#modal-address-component');
            this.$modalComponentValidacion = this.$('#modal-address-component-validacion');
        },

        focusComponent: function(e) {
            $("#"+$(e.currentTarget).attr("data-field")).focus();
        },

        addressChanged: function(e) {
            this.inputContent = $(e.currentTarget);
            this.inputContentNm = this.$("#"+this.inputContent.attr("data-nm-name"));
            this.inputContentNmValue = this.$("#"+this.inputContent.attr("data-nm-value"));

            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$addressField = this.$modalComponent.find('#koi_direccion');
            this.$addressNomenclaturaField = this.$modalComponent.find('#koi_direccion_nm');
            this.$formComponent = this.$modalComponent.find('#form-address-component');

            // Initialize
            this.addressData = new Array();
            this.addressDataNm = new Array();
            this.num = new Array();

            // Validate nomenclaturas
            this.validaciones = ['Agencia','Agrupación','Almacen','Autopista','Avenida','Avenida Carrera','Barrio','Boulevar','Calle','Camino','Carrera','Carretera','Casa','Celula','Centro Comercial','Ciudadela','Conjunto','Conjunto Residencial','Corregimiento','Departamento','Deposito','Edificio','Entrada','Etapa','Finca','Hacienda','Lote','Modulo','Municipio','Parcela','Parque','Parqueadero','Pasaje','Paseo','Predio','Puente','Puesto','Salón','Salón Comunal','Sector','Suite','Terminal','Terraza','Torre','Unidad','Unidad Residencial','Urbanización','Variante','Vereda','Zona','Zona Franca'];

            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initAlertify == 'function' )
                window.initComponent.initAlertify();

            this.$formComponent.validator();

            // Modal show
            this.$modalComponent.modal('show');
        },

        addAddress: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                this.inputContent.val( this.$addressField.val() );
                this.inputContentNm.text( this.$addressNomenclaturaField.val() );
                this.inputContentNmValue.val( this.$addressNomenclaturaField.val() );
                this.$modalComponent.modal('hide');
            }
        },

        listeningAddress: function(e){
            if( parseInt($(e.target).text().trim()) > 0 || parseInt($(e.target).text().trim()) < 9 ){
                this.num = $(e.target).text().trim();
                if( parseInt(this.addressData[this.addressData.length-1]) > 0 || parseInt(this.addressData[this.addressData.length-1]) < 9){
                    this.addressData[this.addressData.length-1] += this.num;
                    this.addressDataNm[this.addressDataNm.length-1] += this.num;
                }else{
                    this.addressData.push( this.num );
                    this.addressDataNm.push( this.num );
                }
            }else{
                this.num = [];
                if( this.addressData[this.addressData.length-1] != $(e.target).text().trim() ){
                    for (var i = 0; i < this.validaciones.length; i++) {
                        if($(e.target).text().trim() == this.validaciones[i]){
                            this.$modalComponentValidacion.find('.modal-content').html( this.templateSelect( { } ));
                            this.$modalComponentValidacion.find('.modal-title').text( $(e.target).text().trim() );
                            this.$modalComponentValidacion.modal('show');
                        }
                    }

                    if($(e.target).text().trim() == '#' || $(e.target).text().trim() == '-'){
                        this.addressData.push( $(e.target).text().trim() );
                        this.addressDataNm.push( ' ' );
                    }else{
                        this.addressData.push( $(e.target).text().trim() );
                        this.addressDataNm.push( $(e.target).attr('data-key') );
                    }
                }else{
                    alertify.error('No puede seleccionar dos nomenclaturas iguales ni más de dos letras seguidas');
                }
            }
            this.buildAddress();
        },

        ChangeSelect: function(e){
            var _this = this;
            this.$component = this.$('#component-input').hide();
            var valor = '';

            if($(e.target).val() == 'si'){
                _this.$component.show();
                $('input#component-input-text').change(function(){
                    var dato = $(this).val( $(this).val().toUpperCase() );
                    var reg = /[^A-Za-z0-9&ÑñáéíóúÁÉÍÓÚ/\s/]/i;
                    for(var i=0; i <= dato.val().length-1; i++){
                        if( !reg.test(dato.val().charAt(i)) ){
                            dato.val().replace(reg,'');
                            valor += dato.val().charAt(i);
                        }
                    }

                    _this.addressData.push( valor );
                    _this.addressDataNm.push( valor );
                    _this.buildAddress();
                    _this.$modalComponentValidacion.modal('hide');
                });
            }else if($(e.target).val() == 'no'){
                _this.$modalComponentValidacion.modal('hide');
            }else{
                return false;
            }
        },

        /**
        * remove last item
        */
        removeLastItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.addressData.pop();
                this.addressDataNm.pop();
                this.buildAddress();
            }
        },

        /**
        * remove item
        */
        removeItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.addressData.length = 0;
                this.addressDataNm.length = 0;
                this.num.length = 0;
                this.buildAddress();
            }
        },

     	/**
        * Built address
        */
		buildAddress: function() {
            var addreess = $.grep(this.addressData, Boolean).join(' ').trim();
            this.$addressField.val( addreess );

            var addreessNm = $.grep(this.addressDataNm, Boolean).join(' ').trim();
            this.$addressNomenclaturaField.val( addreessNm );
		}
    });
})(jQuery, this, this.document);
/**
* Class ConfirmWindow
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ConfirmWindow = Backbone.View.extend({

        el: '#modal-confirm-component',
        parameters: {
            template: null,
            titleConfirm: '',
            onConfirm: null,
            callBack: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // extends attributtes
            if( opts != undefined && _.isObject(opts.parameters) )
                this.parameters = _.extend({}, this.parameters, opts.parameters );

        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = {};

            // Extend attributes confirm window
           	_.extend(attributes, this.parameters.dataFilter);
            this.$el.find('.content-modal').html( this.parameters.template(attributes) );

            // Change modal title
            this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
			this.$el.modal('show');

            // delegate events
	        $(this.el).off('click', '.confirm-action');
            this.undelegateEvents();
            this.delegateEvents({ 'click .confirm-action': 'onConfirm' });

            return this;
        },

        /**
        * Confirm
        */
        onConfirm: function (e) {

            e.preventDefault();
            var _this = this;

            this.$el.modal('hide');

            if( typeof this.parameters.onConfirm == 'function' ) {
                this.parameters.onConfirm.call(null, this.parameters.dataFilter );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class ComponentConsecutiveView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentConsecutiveView = Backbone.View.extend({

      	el: 'body',
		events: {
			'change .change-sucursal-consecutive-koi-component': 'sucursalChange'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

        sucursalChange: function(e) {
            var _this = this;
        		module = $(e.currentTarget).attr("data-module");
				sucursal = $(e.currentTarget).val();

            // Reference to fields
            this.$consecutive = $("#"+$(e.currentTarget).attr("data-field"));
        	this.$wrapperContent = $("#"+$(e.currentTarget).attr("data-wrapper"));

            $.ajax({
                url: window.Misc.urlFull(Route.route('sucursales.show', {sucursales: sucursal})),
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wrapperContent );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wrapperContent );

                // Eval consecutive
                var consecutive = 0;
                if(module == 'traslados') consecutive = resp.sucursal_traslado;

                // Set consecutive
                _this.$consecutive.val( consecutive + 1 );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wrapperContent );
                alertify.error(thrownError);
            });
        },
    });


})(jQuery, this, this.document);

/**
* Class ComponentCreateResourceView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentCreateResourceView = Backbone.View.extend({

      	el: 'body',
		events: {
            'click .btn-add-resource-koi-component': 'addResource',
            'submit #form-create-resource-component': 'onStore'
		},
        parameters: {
        },

        /**
        * Constructor Method
        */
		initialize: function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

			// Initialize
            this.$modalComponent = this.$('#modal-add-resource-component');
            this.$wraperError = this.$('#error-resource-component');
            this.$wraperContent = this.$('#content-create-resource-component').find('.modal-body');
		},

		/**
        * Display form modal resource
        */
		addResource: function(e) {
            // References
            this.resource = $(e.currentTarget).attr("data-resource");
            this.$resourceField = $("#"+$(e.currentTarget).attr("data-field"));
            this.parameters = {};

            if(this.resource == 'contacto') {
                var address = null, nomenclatura = null, municipio = null;
                this.$inputPhone = this.$("#"+$(e.currentTarget).attr("data-phone"));
                this.$inputAddress = this.$("#"+$(e.currentTarget).attr("data-address"));
                this.$inputCity = this.$("#"+$(e.currentTarget).attr("data-city"));
                this.$inputEmail = this.$("#"+$(e.currentTarget).attr("data-email"));
                this.parameters.tcontacto_tercero = $(e.currentTarget).attr("data-tercero");
                if( _.isUndefined(this.parameters.tcontacto_tercero) || _.isNull(this.parameters.tcontacto_tercero) || this.parameters.tcontacto_tercero == '') {
                    alertify.error('Por favor ingrese cliente antes agregar contacto.');
                    return;
                }

                // Get default values form
                address = $(e.currentTarget).attr("data-address-default");
                nomenclatura = $(e.currentTarget).attr("data-address-nomenclatura-default");
                municipio = $(e.currentTarget).attr("data-municipio-default");
            }

            // stuffToDo resource
            var _this = this,
	            stuffToDo = {
	                'centrocosto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Centros de costo');

    	            	_this.model = new app.CentroCostoModel();
                        var template = _.template($('#add-centrocosto-tpl').html());
            			_this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
    	            },
                    'folder' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Folder');

                        _this.model = new app.FolderModel();
                        var template = _.template($('#add-folder-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'tercero' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Tercero');

                        _this.model = new app.TerceroModel();
                        var template = _.template($('#add-tercero-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );

                        _this.$formAccounting = _this.$modalComponent.find('#form-accounting');
                    },
                    'grupo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Grupo inventario');

                        _this.model = new app.GrupoModel();
                        var template = _.template($('#add-grupo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'subgrupo' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Subrupo inventario');

                        _this.model = new app.SubGrupoModel();
                        var template = _.template($('#add-subgrupo-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'unidadmedida' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Unidad de medida');

                        _this.model = new app.UnidadModel();
                        var template = _.template($('#add-unidad-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'producto' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Producto');

                        _this.model = new app.ProductoModel();
                        var template = _.template($('#add-producto-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'contacto' : function() {
                        _this.$resourceName = $("#"+$(e.currentTarget).attr("data-name"));
                        _this.$modalComponent.find('.inner-title-modal').html('Contacto');

                        _this.model = new app.ContactoModel({
                            tcontacto_direccion: address,
                            tcontacto_direccion_nomenclatura: nomenclatura,
                            tcontacto_municipio: municipio
                        });
                        var template = _.template($('#add-contacto-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'areap' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Área de producción');

                        _this.model = new app.AreapModel();
                        var template = _.template($('#add-areap-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'maquinap' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Máquina de producción');

                        _this.model = new app.MaquinapModel();
                        var template = _.template($('#add-maquinap-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'materialp' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Material de producción');

                        _this.model = new app.MaterialpModel();
                        var template = _.template($('#add-materialp-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
                    'acabadop' : function() {
                        _this.$modalComponent.find('.inner-title-modal').html('Acabado de producción');

                        _this.model = new app.AcabadopModel();
                        var template = _.template($('#add-acabadop-tpl').html());
                        _this.$modalComponent.find('.content-modal').html( template(_this.model.toJSON()) );
                    },
	            };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                this.$wraperError.hide().empty();

	            // Events
            	this.listenTo( this.model, 'sync', this.responseServer );
            	this.listenTo( this.model, 'request', this.loadSpinner );

                // to fire plugins
                this.ready();

				this.$modalComponent.modal('show');
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
        * Event Create Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                this.$wraperError.hide().empty();

                e.preventDefault();
                var data = $.extend({}, this.parameters, window.Misc.formToJson( e.target ));

                if (this.resource == 'tercero') {
                    data = $.extend({}, data, window.Misc.formToJson( this.$formAccounting ));
                }

                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

            // response success or error
            var text = resp.success ? '' : resp.errors;
            if( _.isObject( resp.errors ) ) {
                text = window.Misc.parseErrors(resp.errors);
            }

            if( !resp.success ) {
                this.$wraperError.empty().append(text);
                this.$wraperError.show();
                return;
            }

            // stuffToDo Response success
            var _this = this,
                stuffToDo = {
                    'centrocosto' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('centrocosto_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'folder' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('folder_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'tercero' : function() {
                        _this.$resourceField.val(_this.model.get('tercero_nit')).trigger('change');
                    },
                    'grupo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('grupo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'subgrupo' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('subgrupo_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'unidadmedida' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('unidadmedida_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'producto' : function() {
                        _this.$resourceField.val(_this.model.get('producto_codigo')).trigger('change');
                    },
                    'contacto' : function() {
                        _this.$resourceField.val(_this.model.get('id'));
                        _this.$resourceName.val(_this.model.get('tcontacto_nombre'));

                        if(_this.$inputPhone.length) {
                            _this.$inputPhone.val( _this.model.get('tcontacto_telefono') );
                        }

                        if(_this.$inputAddress.length) {
                            _this.$inputAddress.val( _this.model.get('tcontacto_direccion') );
                        }

                        if(_this.$inputEmail.length) {
                            _this.$inputEmail.val( _this.model.get('tcontacto_email') );
                        }

                        if(_this.$inputCity.length) {
                            _this.$inputCity.val( _this.model.get('tcontacto_municipio') ).trigger('change');
                        }
                    },
                    'areap' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('areap_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'maquinap' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('maquinap_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'materialp' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('materialp_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                    'acabadop' : function() {
                        _this.$resourceField.select2({ data: [{id: _this.model.get('id'), text: _this.model.get('acabadop_nombre')}] }).trigger('change');
                        _this.$resourceField.val(_this.model.get('id')).trigger('change');
                    },
                };

            if (stuffToDo[this.resource]) {
                stuffToDo[this.resource]();

                // Fires libraries js
                if( typeof window.initComponent.initSelect2 == 'function' )
                    window.initComponent.initSelect2();

                this.$modalComponent.modal('hide');
            }
        }
    });


})(jQuery, this, this.document);

/**
* Class RolesListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.Factura4ListView = Backbone.View.extend({

        el: '#browse-factura4-list',
        parameters: {
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Info adicional
            this.$valor = this.$('.total');
            this.$totalCount = this.$('#total_count');

            this.$porvencer = this.$('#porvencer');
            this.$menor30 = this.$('#menor30');
            this.$porvencer_saldo = this.$('#porvencer_saldo');
            this.$menor30_saldo = this.$('#menor30_saldo');
            this.$menor60 = this.$('#menor60');
            this.$menor60_saldo = this.$('#menor60_saldo');
            this.$menor90 = this.$('#menor90');
            this.$menor90_saldo = this.$('#menor90_saldo');
            this.$menor180 = this.$('#menor180');
            this.$menor180_saldo = this.$('#menor180_saldo');
            this.$menor360 = this.$('#menor360');
            this.$menor360_saldo = this.$('#menor360_saldo');
            this.$mayor360 = this.$('#mayor360');
            this.$mayor360_saldo = this.$('#mayor360_saldo');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view rol by model
        * @param Object contactModel Model instance
        */
        addOne: function ( factura4Model ) {
            var view = new app.Factura4ItemView({
                model: factura4Model,
                parameters: {
                    edit: this.parameters.edit,
                    call: this.parameters.call,
                    template: this.parameters.template,
                }
            });
            factura4Model.view = view;
            this.$el.prepend( view.render().el );

            // Calculate total if call tercero || factura
            if( this.parameters.call == 'tercero' )
                this.totalize();

            // Ready asiento
            if( this.parameters.call == 'asiento' )
                this.ready();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Render totalize valor
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$valor.length) {
                this.$valor.html( window.Misc.currency(data.valor) );
            }

            if(this.$porvencer.length) {
                this.$totalCount.html( data.tcount );
                this.$porvencer.html( data.porvencer.count );
                this.$porvencer_saldo.html( window.Misc.currency( data.porvencer.saldo ) );
            }

            if(this.$menor30.length) {
                this.$menor30.html( data.menor30.count );
                this.$menor30_saldo.html( window.Misc.currency( data.menor30.saldo ) );
            }

            if(this.$menor60.length) {
                this.$menor60.html( data.menor60.count );
                this.$menor60_saldo.html( window.Misc.currency( data.menor60.saldo ) );
            }

            if(this.$menor90.length) {
                this.$menor90.html( data.menor90.count );
                this.$menor90_saldo.html( window.Misc.currency( data.menor90.saldo ) );
            }

            if(this.$menor180.length) {
                this.$menor180.html( data.menor180.count );
                this.$menor180_saldo.html( window.Misc.currency( data.menor180.saldo ) );
            }

            if(this.$menor360.length) {
                this.$menor360.html( data.menor360.count );
                this.$menor360_saldo.html( window.Misc.currency( data.menor360.saldo ) );
            }

            if(this.$mayor360.length) {
                this.$mayor360.html( data.mayor360.count );
                this.$mayor360_saldo.html( window.Misc.currency( data.mayor360.saldo ) );
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class FacturaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.Factura4ItemView = Backbone.View.extend({

        tagName: 'tr',
        parameters: {
            template: null,
            call: null,
            edit: false,
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.template = this.parameters.template;

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;

            if( this.parameters.call == 'tercero' ) {
                if( attributes.days <= 0 && attributes.days >= -30 ){
                    this.$el.addClass('bg-menor30');
                }else if ( attributes.days <= -31 && attributes.days >= -60 ){
                    this.$el.addClass('bg-menor60');
                }else if ( attributes.days <= -61 && attributes.days >= -90 ){
                    this.$el.addClass('bg-menor90');
                }else if ( attributes.days <= -91 && attributes.days >= -180 ){
                    this.$el.addClass('bg-menor180');
                }else if ( attributes.days <= -181 && attributes.days >= -360 ){
                    this.$el.addClass('bg-menor360');
                }else if ( attributes.days < -360 ){
                    this.$el.addClass('bg-mayor360');
                }
            }

            this.$el.html( this.template(attributes) );
            return this;
        }
    });
})(jQuery, this, this.document);

/**
* Class ComponentDocumentView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentDocumentView = Backbone.View.extend({
        
      	el: 'body',
		events: {
            'change .select-filter-document-koi-component': 'folderChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		folderChanged: function(e) {
			var _this = this;
			
			this.$inputContent = $(e.currentTarget);
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
			this.$inputDocument = this.$("#"+$(e.currentTarget).attr("data-documents"));

			var folder = this.$inputContent.val();
			
			// Clear items
			this.$inputDocument.find("option:gt(0)").remove();

			if(!_.isUndefined(folder) && !_.isNull(folder) && folder != '') {
				// Get documentos
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('documentos.filter')),
	                type: 'GET',
	                data: { folder: folder },
	                beforeSend: function() {
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {  
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                	if( _.isObject( resp.documents ) ) {
							$.each(resp.documents, function(index, doc) {   
								_this.$inputDocument.append($("<option></option>").attr("value",doc.id).text(doc.documento_nombre)); 
							});
							_this.$inputDocument.change();
		                }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		}
    });


})(jQuery, this, this.document);

/**
* Class ComponentGlobalView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentGlobalView = Backbone.View.extend({

      	el: 'body',
		events: {
            'click .sidebar-toggle': 'clickSidebar',
            'click .history-back': 'clickHistoryBack',
            'hidden.bs.modal': 'multiModal'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		clickSidebar: function(e) {
			e.preventDefault();

			var expiration = new Date();
			expiration.setFullYear(expiration.getFullYear() + 1);

			// Create or update the cookie:
			document.cookie = "sidebar_toggle=" + (this.$el.hasClass('sidebar-collapse') ? '' : 'sidebar-collapse') + "; path=/; expires=" + expiration.toUTCString();
		},

		clickHistoryBack: function(e) {
			e.preventDefault();

			window.history.back();
		},

		multiModal: function(){
			if( $('.modal.in').length > 0){
                $('body').addClass('modal-open');
            }
		},
    });
})(jQuery, this, this.document);

/**
* Class InventarioActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.InventarioActionView = Backbone.View.extend({
    	el: 'body',

    	events:{
            'submit #form-create-inventario-component-source': 'onStoreInventario',
    	},

        parameters: {
            data: { },
        },

        templateChooseItemsRollo: _.template( ($('#choose-itemrollo-inventory-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize : function( opts )
        {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modalIn = this.$('#modal-inventario-component');

            // Collection item rollo
            this.itemRolloINList = new app.ItemRolloINList();
            // Collection series producto
            this.productoSeriesINList = new app.ProductoSeriesINList();

            // Events Listeners
            this.listenTo( this.itemRolloINList, 'reset', this.addAllItemRolloInventario );
            this.listenTo( this.itemRolloINList, 'store', this.onStoreItemRolloInventario );

            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function()
        {
            var resp = this.parameters,
                _this = this,
                stuffToDo = {
                    'metrado': function() {
                        if (resp.tipo === 'E') {
                            // Code...
                        }else {
                            _this.$modalIn.find('.content-modal').empty().html(_this.templateChooseItemsRollo( ) );
                            _this.$modalIn.find('.modal-title').text('Inventario - Salidas de productos metrados');
                        }

                        // Reference inventario
                        _this.metrajeReference(resp);
                    },
                    'series': function() {
                        console.log('series');
                        // Reference inventario
                        _this.serieReference(resp);
                    },
                    unidades: function() {
                        console.log('unidades');
                        // Reference inventario
                        _this.unidadesReference(resp);
                    }
                };
            if (stuffToDo[resp.action]) {
                this.parameters.data = $.extend({}, this.parameters.data);
                this.parameters.data.action = resp.action;
                stuffToDo[resp.action]();
            }
		},

        /**
        * Reference add RolloMetrado
        */
        metrajeReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code..
            }else {
                //Salidas
                this.$wraperItemRollo = this.$('#browse-chooseitemtollo-list');
                this.itemRolloINList.fetch({ reset: true, data: { producto: attributes.producto,   sucursal: attributes.data.sucursal } });
            }

            // Open modal
            this.$modalIn.modal('show');
        },
        /**
        * Reference add Series
        */
        serieReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code...
            }else {
                // Salidas
                this.parameters.data = $.extend({}, this.parameters.data);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * Reference add No series No metros
        */
        unidadesReference: function(attributes)
        {
            if (attributes.tipo === 'E') {
                // Code...
            }else {
                // Salidas
                this.parameters.data = $.extend({}, this.parameters.data);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * Render view task by model
        * @param Object ItemRolloModel Model instance
        */
        addOneItemRolloInventario: function (ItemRolloModel, choose)
        {
            choose || (choose = false);

            var view = new app.ItemRolloINListView({
                model: ItemRolloModel,
                parameters: {
                    choose: choose
                }
            });
            this.$wraperItemRollo.append( view.render().el );
            this.ready();
        },

        /**
        * Render all view tast of the collection
        */
        addAllItemRolloInventario: function ()
        {
            var _this = this;
            this.itemRolloINList.forEach(function(model, index) {
                _this.addOneItemRolloInventario(model, true)
            });
        },
        /*
        * Validate Carro temporal
        */
        onStoreInventario: function (e)
        {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.parameters.data = $.extend({}, this.parameters.data);
                this.parameters.data.items = window.Misc.formToJson(e.target);
                this.collection.trigger('store', this.parameters.data);
            }
        },
        /**
        * fires libraries js
        */
        ready: function ()
        {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        /**
        * Respose of de server
        */
        responseServer: function ( model, resp, opts )
        {
            if(!_.isUndefined(resp.success)) {
                if( resp.success ) {
                    // Close modals
                    this.$modalIn.modal('hide');

                    // Clear Form of car temp
                    if (!_.isUndefined(this.parameters.form))
                        window.Misc.clearForm(this.parameters.form);
                }
            }
        }

    });
})(jQuery, this, this.document);

/**
* Class ItemRolloINListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ItemRolloINListView = Backbone.View.extend({

        tagName: 'tr',
        template: null,

        /**
        * Constructor Method
        */
        initialize: function( opts ) {

            if (opts.parameters.choose) {
                this.template = _.template( ($('#choose-itemrollo-tpl').html() || '') );
            } else if (!opts.parameters.choose && opts.parameters.show) {
                this.template = _.template( ($('#itemrollo-tpl').html() || '') );
            }else{
                this.template = _.template( ($('#add-itemrollo-tpl').html() || '') );
            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class ProdbodeListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ItemRolloListView = Backbone.View.extend({

        el: '#browse-itemtollo-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // if was passed itemrollo code
            if( !_.isUndefined(this.parameters.dataFilter.sucursal) && !_.isNull(this.parameters.dataFilter.sucursal) ){
                 this.confCollection.data.sucursal = this.parameters.dataFilter.sucursal;
                 this.confCollection.data.producto = this.parameters.dataFilter.producto_id;
                this.collection.fetch( this.confCollection );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
        },
        /**
        * Render view contact by model
        * @param Object itemRolloModel Model instance
        */
        addOne: function (itemRolloModel) {

            var view = new app.ItemRolloINListView({
                model: itemRolloModel,
                parameters: {
                    choose: this.parameters.choose,
                    show:this.parameters.show
                }
            });

            itemRolloModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);

/**
* Class ProdbodeItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProdbodeItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-seriesprodbode-tpl').html() || '') ),
        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });
})(jQuery, this, this.document);

/**
* Class ProdbodeListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProdbodeListView = Backbone.View.extend({

        el: '#browse-prodbode-table',
        events: {
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // if was passed itemrollo code
            if( !_.isUndefined(this.parameters.dataFilter.call) && !_.isNull(this.parameters.dataFilter.call) ){
                this.confCollection.data.producto = this.parameters.dataFilter.producto_id;
                this.collection.fetch( this.confCollection );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
        },
        /**
        * Render view contact by model
        * @param Object prodbodeModel Model instance
        */
        addOne: function (prodbodeModel) {
            var view = new app.ProdbodeItemView({
                model: prodbodeModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            prodbodeModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);

/**
* Class ComponentReportView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentReportView = Backbone.View.extend({

      	el: 'body',
		events: {
			'click .btn-export-pdf-koi-component': 'onPdf',
			'click .btn-export-xls-koi-component': 'onXls',
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		onPdf: function(e) {
			this.$("#type-report-koi-component").val('pdf');
		},

		onXls: function(e) {
			this.$("#type-report-koi-component").val('xls');
		}
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchContactoView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchContactoView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-contacto-component-tpl').html() || '') ),

		events: {
            'click .btn-koi-search-contacto-component-table': 'searchOrden',
            'click .btn-search-koi-search-contacto-component': 'search',
            'click .btn-clear-koi-search-contacto-component': 'clear',
            'click .a-koi-search-contacto-component-table': 'setContacto'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-contacto-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchContactoNombres = this.$('#koi_search_contacto_nombres');
            this.$searchContactoApellidos = this.$('#koi_search_contacto_apellidos');

            // Validate tercero
			this.$resourceTercero = this.$("#"+$(e.currentTarget).attr("data-tercero"));
			var tercero = this.$resourceTercero.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar contacto.');
                return;
            }

            this.$contactoSearchTable = this.$modalComponent.find('#koi-search-contacto-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
            this.$inputPhone = this.$("#"+$(e.currentTarget).attr("data-phone"));
            this.$inputAddress = this.$("#"+$(e.currentTarget).attr("data-address"));
            this.$inputNomenclatura = this.$("#"+$(e.currentTarget).attr("data-nomenclatura"));
            this.$labelNomenclatura = this.$("#"+$(e.currentTarget).attr("data-name-nomenclatura"));
            this.$inputCity = this.$("#"+$(e.currentTarget).attr("data-city"));
			this.$inputEmail = this.$("#"+$(e.currentTarget).attr("data-email"));

			this.contactoSearchTable = this.$contactoSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('terceros.contactos.index') ),
                    data: function( data ) {
                        data.tcontacto_nombres = _this.$searchContactoNombres.val(),
                        data.tcontacto_apellidos = _this.$searchContactoApellidos.val(),
                        data.tcontacto_tercero = tercero
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tcontacto_nombres', name: 'tcontacto_nombres' },
                    { data: 'tcontacto_apellidos', name: 'tcontacto_apellidos' },
                    { data: 'tcontacto_nombre', name: 'tcontacto_nombre' },
                    { data: 'tcontacto_telefono', name: 'tcontacto_telefono' },
                    { data: 'municipio_nombre', name: 'municipio_nombre' },
                    { data: 'tcontacto_direccion', name: 'tcontacto_direccion' },
                    { data: 'tcontacto_municipio', name: 'tcontacto_municipio' },
                    { data: 'tcontacto_email', name: 'tcontacto_email' }
                ],
                columnDefs: [
                    {
                        targets: 3,
                        width: '40%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-contacto-component-table">' + data + '</a>';
                        }
                    },
                	{
                        targets: [0,1,2,7,8],
                        visible: false
                    }
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setContacto: function(e) {
			e.preventDefault();

	        var data = this.contactoSearchTable.row( $(e.currentTarget).parents('tr') ).data();
			this.$inputContent.val( data.id );
			this.$inputName.val( data.tcontacto_nombre );
			if(this.$inputPhone.length) {
                this.$inputPhone.val( data.tcontacto_telefono );
            }
            if(this.$inputAddress.length) {
                this.$inputAddress.val( data.tcontacto_direccion );
            }
            if(this.$inputNomenclatura.length) {
                this.$inputNomenclatura.val( data.tcontacto_direccion_nomenclatura );
            }
            if(this.$labelNomenclatura.length) {
                this.$labelNomenclatura.text( data.tcontacto_direccion_nomenclatura );
            }
            if(this.$inputCity.length) {
                this.$inputCity.val( data.tcontacto_municipio ).trigger('change');
            }
            if(this.$inputEmail.length) {
				this.$inputEmail.val( data.tcontacto_email );
			}

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.contactoSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchContactoNombres.val('');
            this.$searchContactoApellidos.val('');

            this.contactoSearchTable.ajax.reload();
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchCuentaView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchCuentaView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-plancuenta-component-tpl').html() || '') ),

		events: {
			'change input.plancuenta-koi-component': 'cuentaChanged',
            'click .btn-koi-search-plancuenta-component': 'searchCuenta',
            'click .btn-search-koi-search-plancuenta-component': 'search',
            'click .btn-clear-koi-search-plancuenta-component': 'clear',
            'click .a-koi-search-plancuenta-component-table': 'setCuenta'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-component');
		},

		searchCuenta: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchCuenta = this.$('#koi_search_plancuentas_cuenta');
            this.$searchName = this.$('#koi_search_plancuentas_nombre');

            this.$plancuentasSearchTable = this.$modalComponent.find('#koi-search-plancuenta-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

			this.$inputCentro = this.$("#"+this.$inputContent.attr("data-centro"));
			this.$inputBase = this.$("#"+this.$inputContent.attr("data-base"));
			this.$inputValor = this.$("#"+this.$inputContent.attr("data-valor"));
			this.$inputTasa = this.$("#"+this.$inputContent.attr("data-tasa"));

            this.plancuentasSearchTable = this.$plancuentasSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('plancuentas.index') ),
                    data: function( data ) {
                        data.plancuentas_cuenta = _this.$searchCuenta.val();
                        data.plancuentas_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentas_cuenta', name: 'plancuentas_cuenta' },
                    { data: 'plancuentas_nivel', name: 'plancuentas_nivel' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'plancuentas_naturaleza', name: 'plancuentas_naturaleza' },
                    { data: 'plancuentas_tercero', name: 'plancuentas_tercero' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-plancuenta-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '10%',
                        searchable: false
                    },
                    {
                        targets: 3,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return data == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return data ? 'Si' : 'No';
                        }
                    }
                ]
			});

        	// Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setCuenta: function(e) {
			e.preventDefault();

	        var data = this.plancuentasSearchTable.row( $(e.currentTarget).parents('tr') ).data();

			this.$inputContent.val( data.plancuentas_cuenta );
			this.$inputName.val( data.plancuentas_nombre );
			this.$inputName.val( data.plancuentas_nombre );

			// Clear centro costo
            if(this.$inputCentro.length) {
        		this.$inputCentro.val('').trigger('change');
            }

            // Clear base
            if(this.$inputBase.length) {
				this.$inputBase.prop('readonly', true);
			}

			this.$modalComponent.modal('hide');

		    // Other actions
            this.actions(data);
		},

		search: function(e) {
			e.preventDefault();

		    this.plancuentasSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

			this.$searchCuenta.val('');
			this.$searchName.val('');

			this.plancuentasSearchTable.ajax.reload();
		},

		cuentaChanged: function(e) {
			var _this = this;

			// References
			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$inputBase = this.$("#"+$(e.currentTarget).attr("data-base"));
			this.$inputTasa = this.$("#"+$(e.currentTarget).attr("data-tasa"));

			this.$inputValor = this.$("#"+$(e.currentTarget).attr("data-valor"));
			this.$inputCentro = this.$("#"+$(e.currentTarget).attr("data-centro"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var cuenta = this.$inputContent.val();

			// Before eval clear data
			this.$inputName.val('');

			// Clear centro costo
            if(this.$inputCentro.length) {
        		this.$inputCentro.val('').trigger('change');
            }

            // Clear base
            if(this.$inputBase.length) {
				this.$inputBase.prop('readonly', true);
			}

			// Clear tasa
            if(this.$inputTasa.length) {
				this.$inputTasa.val('');
			}

			if(!_.isUndefined(cuenta) && !_.isNull(cuenta) && cuenta != '') {
				// Get plan cuenta
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('plancuentas.search')),
	                type: 'GET',
	                data: { plancuentas_cuenta: cuenta },
	                beforeSend: function() {
						window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
                   if(resp.success) {
	                    // Set name
	                    if(!_.isUndefined(resp.plancuentas_nombre) && !_.isNull(resp.plancuentas_nombre)){
							_this.$inputName.val(resp.plancuentas_nombre);
	                    }

	                    // Other actions
	                    _this.actions(resp);
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });

	     	}
		},

		/**
        * Other actions on set cuenta
        */
		actions: function (data) {
            // Eval base
        	if(this.$inputBase.length) {
            	if(!_.isUndefined(data.plancuentas_tasa) && !_.isNull(data.plancuentas_tasa) && data.plancuentas_tasa > 0) {
            		// Case plancuentas_tasa eval value
        			this.$inputBase.prop('readonly', false);
                    var base = this.$inputBase.inputmask('unmaskedvalue');
     				this.$inputValor.val( (data.plancuentas_tasa * base) / 100);
            	}else{
            		// Case without plancuentas_tasa
            		this.$inputBase.val('');
            	}
            }

            // Eval centro costo
            if(this.$inputCentro.length) {
            	if(!_.isUndefined(data.plancuentas_centro) && !_.isNull(data.plancuentas_centro) && data.plancuentas_centro > 0) {
            		this.$inputCentro.val( data.plancuentas_centro ).trigger('change');
            	}
            }

            // Eval tasa
            if(this.$inputTasa.length) {
            	if(!_.isUndefined(data.plancuentas_tasa) && !_.isNull(data.plancuentas_tasa) && data.plancuentas_tasa > 0) {
            		this.$inputTasa.val( data.plancuentas_tasa );
            	}else{
					this.$inputTasa.val('');
				}
			}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchFacturaView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchFacturaView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-factura-component-tpl').html() || '') ),

		events: {
			// 'change input.factura-koi-component': 'facturaChanged',
            'click .btn-koi-search-factura-component-table': 'searchFactura',
            'click .btn-search-koi-search-factura-component': 'search',
            'click .btn-clear-koi-search-factura-component': 'clear',
            'click .a-koi-search-factura-component-table': 'setFactura'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-factura-component');
		},

		searchFactura: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');

            this.$facturaSearchTable = this.$modalComponent.find('#koi-search-factura-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputId = this.$("#"+this.$inputContent.attr("data-referencia"));
            this.$inputNit = this.$("#"+this.$inputContent.attr("data-nit"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$factura = this.$inputContent.attr("data-factura");

			this.facturaSearchTable = this.$facturaSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturas.index') ),
                    data: function( data ) {
                        data.factura1_numero = _this.$searchfacturaNumero.val();
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                    }
                },
                columns: [
                    { data: 'factura1_numero', name: 'factura1_numero' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-factura-component-table">' + data + '</a>';
                        }
                    }
                ]

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setFactura: function(e) {
			e.preventDefault();
	        var data = this.facturaSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.factura1_numero );
            this.$inputId.val( data.id );
            this.$inputNit.val( data.tercero_nit );
            this.$inputName.val( data.tercero_nombre );

			if(this.$factura == 'true'){
                this.$inputContent.trigger('change');
            }

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.facturaSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchfacturaNumero.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturaSearchTable.ajax.reload();
		},

		// facturaChanged: function(e) {
		// 	var _this = this;
        //
		// 	this.$inputContent = $(e.currentTarget);
		// 	this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
		// 	this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
        //
		// 	var factura = this.$inputContent.val();
        //
        //     // Before eval clear data
        //     this.$inputName.val('');
        //
		// 	if(!_.isUndefined(factura) && !_.isNull(factura) && factura != '') {
		// 		// Get Factura
	    //         $.ajax({
	    //             url: window.Misc.urlFull(Route.route('facturas.search')),
	    //             type: 'GET',
	    //             data: { factura_numero: factura },
	    //             beforeSend: function() {
		// 				_this.$inputName.val('');
	    //                 window.Misc.setSpinner( _this.$wraperConten );
	    //             }
	    //         })
	    //         .done(function(resp) {
	    //             window.Misc.removeSpinner( _this.$wraperConten );
	    //             if(resp.success) {
	    //                 if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
		// 					_this.$inputName.val(resp.tercero_nombre);
	    //                 }
	    //             }
	    //         })
	    //         .fail(function(jqXHR, ajaxOptions, thrownError) {
	    //             window.Misc.removeSpinner( _this.$wraperConten );
	    //             alertify.error(thrownError);
	    //         });
	    //  	}
		// },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchOrdenPView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchOrdenPView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-ordenp-component-tpl').html() || '') ),

		events: {
			'change input.ordenp-koi-component': 'ordenpChanged',
            'click .btn-koi-search-orden-component-table': 'searchOrden',
            'click .btn-search-koi-search-ordenp-component': 'search',
            'click .btn-clear-koi-search-ordenp-component': 'clear',
            'click .a-koi-search-ordenp-component-table': 'setOrden'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-ordenp-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchordenpOrden = this.$('#searchordenp_ordenp_numero');
            this.$searchordenpTercero = this.$('#searchordenp_tercero');
            this.$searchordenpTerceroNombre = this.$('#searchordenp_tercero_nombre');

            this.$ordersSearchTable = this.$modalComponent.find('#koi-search-ordenp-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$factura = this.$inputContent.attr("data-factura");
            this.$estado = this.$inputContent.attr("data-estado");

            /* Render in <a> dashboard */
            this.$fieldRender = this.$($(e.currentTarget)).attr("data-render");

			this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        data.factura = _this.$factura;
                        data.orden_estado = _this.$estado;
                        data.orden_numero = _this.$searchordenpOrden.val();
                        data.orden_tercero_nit = _this.$searchordenpTercero.val();
                    }
                },
                columns: [
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'orden_fecha', name: 'orden_fecha' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            // Render show tercero in dashboard
                            if (_this.$fieldRender == "show")
                            {
                                return '<a href='+ window.Misc.urlFull( Route.route('ordenes.show', { ordenes: full.id}))+'>' + data + '</a>';
                            }

                        	return '<a href="#" class="a-koi-search-ordenp-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false
                    },
                    {
                        targets: 4 ,
                        render: function ( data, type, full, row ) {
                            return window.moment(data).format('YYYY-MM-DD');
                        }
                    }
                ]

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setOrden: function(e) {
			e.preventDefault();
	        var data = this.ordersSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.orden_codigo );
            this.$inputName.val( data.tercero_nombre );

            if(this.$factura == 'true'){
                this.$inputContent.trigger('change');
            }

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.ordersSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchordenpOrden.val('');
            this.$searchordenpTercero.val('');
            this.$searchordenpTerceroNombre.val('');

            this.ordersSearchTable.ajax.reload();
		},

		ordenpChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
            this.$estado = this.$inputContent.attr("data-estado");

			var orden = this.$inputContent.val(),
                estado = this.$estado;

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(orden) && !_.isNull(orden) && orden != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('ordenes.search')),
	                type: 'GET',
	                data: { orden_codigo: orden, orden_estado: estado },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
							_this.$inputName.val(resp.tercero_nombre);
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchOrdenP2View of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchOrdenP2View = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-ordenp2-component-tpl').html() || '') ),
		events: {
			'change input.ordenp2-koi-component': 'ordenpChanged',
            'click .btn-koi-search-orden2-component-table': 'searchOrden',
            'click .btn-search-koi-search-ordenp2-component': 'search',
            'click .btn-clear-koi-search-ordenp2-component': 'clear',
            'click .a-koi-search-ordenp2-component-table': 'setOrden'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-ordenp2-component');
		},

		searchOrden: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchOrdenp = this.$('#search_ordenp');
            this.$searchOrdenpNombre = this.$('#search_ordenpnombre');

            this.$ordersSearchTable = this.$modalComponent.find('#koi-search-ordenp2-component-table');
            this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            // Validate tercero
            var tercero = this.$inputContent.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar una orden.');
                return;
            }

			this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.productos.index') ),
                    data: function( data ) {
                    	data.datatables = true;
                        data.search_ordenp = _this.$searchOrdenp.val();
                        data.search_ordenpnombre = _this.$searchOrdenpNombre.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'productop_nombre', name: 'productop_nombre' },
                    { data: 'orden2_cantidad', name: 'orden2_cantidad' },
                    { data: 'orden2_facturado', name: 'orden2_facturado' },
                ],
                order: [
                	[ 2, 'desc' ], [ 3, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                        	return '<a href="#" class="a-koi-search-ordenp2-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2, 3],
                        visible: false,
                    }
                ]

			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setOrden: function(e) {
			e.preventDefault();
	        var data = this.ordersSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.id );
            this.$inputName.val( data.productop_nombre );

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.ordersSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchOrdenp.val('');
            this.$searchOrdenpNombre.val('');

            this.ordersSearchTable.ajax.reload();
		},

		ordenpChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var orden2_id = this.$inputContent.val();

            // Validate tercero
            var tercero = this.$inputContent.attr("data-tercero");
            if( _.isUndefined(tercero) || _.isNull(tercero) || tercero == '') {
                alertify.error('Por favor ingrese cliente antes agregar una orden.');
                return;
            }

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(orden2_id) && !_.isNull(orden2_id) && orden2_id != '') {
				// Get Orden
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('ordenes.productos.search')),
	                type: 'GET',
	                data: { orden2_id: orden2_id },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.productop_nombre) && !_.isNull(resp.productop_nombre)){
							_this.$inputName.val(resp.productop_nombre);
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchProductoView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductoView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-producto-component-tpl').html() || '') ),

		events: {
			'change input.producto-koi-component': 'productoChanged',
            'click .btn-koi-search-producto-component': 'searchProducto',
            'click .btn-search-koi-search-producto-component': 'search',
            'click .btn-clear-koi-search-producto-component': 'clear',
            'click .a-koi-search-producto-component-table': 'setProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-producto-component');
		},

		searchProducto: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchCodigo = this.$('#koi_search_producto_codigo');
            this.$searchNombre = this.$('#koi_search_producto_nombre');

            this.$productosSearchTable = this.$modalComponent.find('#koi-search-producto-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            /* Render in <a> dashboard */
            this.$fieldRender = this.$($(e.currentTarget)).attr("data-render");

			this.productosSearchTable = this.$productosSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productos.index') ),
                    data: function( data ) {
                        data.producto_codigo = _this.$searchCodigo.val();
                        data.producto_nombre = _this.$searchNombre.val();
                    }
                },
                columns: [
                    { data: 'producto_codigo', name: 'producto_codigo' },
                    { data: 'producto_nombre', name: 'producto_nombre' }
                ],
                columnDefs: [
					{
						targets: 0,
						width: '10%',
						searchable: false,
						render: function ( data, type, full, row ) {
                            // Render show tercero in dashboard
                            if (_this.$fieldRender == "show")
                            {
                                return '<a href='+ window.Misc.urlFull( Route.route('productos.show', { productos: full.id}))+'>' + data + '</a>';
                            }
							return '<a href="#" class="a-koi-search-producto-component-table">' + data + '</a>';
						}
					}
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function(e) {
			e.preventDefault();

	        var data = this.productosSearchTable.row( $(e.currentTarget).parents('tr') ).data();

			this.$inputContent.val( data.producto_codigo );
			this.$inputName.val( data.producto_nombre );

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.productosSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchCodigo.val('');
            this.$searchNombre.val('');

            this.productosSearchTable.ajax.reload();
		},

		productoChanged: function(e) {
			var _this = this;

			this.$inputContent = $(e.currentTarget);
			this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));

			var producto = this.$inputContent.val();

            // Before eval clear data
            this.$inputName.val('');

			if(!_.isUndefined(producto) && !_.isNull(producto) && producto != '') {
				// Get Producto
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('productos.search')),
	                type: 'GET',
	                data: { producto_codigo: producto },
	                beforeSend: function() {
						_this.$inputName.val('');
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                    if(!_.isUndefined(resp.producto_nombre) && !_.isNull(resp.producto_nombre)){
							_this.$inputName.val(resp.producto_nombre);
	                    }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchProductopView of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchProductopView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-productop-component-tpl').html() || '') ),
		events: {
            'click .btn-koi-search-productop-component-table': 'searchProducto',
            'click .btn-search-koi-search-productop-component': 'search',
            'click .btn-clear-koi-search-productop-component': 'clear',
            'click .a-koi-search-productop-component-table': 'setProducto'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-productop-component');
		},

		searchProducto: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchCodigo = this.$('#koi_search_productop_codigo');
            this.$searchNombre = this.$('#koi_search_productop_nombre');

            this.$productospSearchTable = this.$modalComponent.find('#koi-search-productop-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
			this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));

            var productop = this.$inputContent.attr("data-productop");

			this.productospSearchTable = this.$productospSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: function( data ) {
                        data.datatables = true;
                        data.id = _this.$searchCodigo.val();
                        data.productop_nombre = _this.$searchNombre.val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'productop_nombre', name: 'productop_nombre' }
                ],
                columnDefs: [
					{
						targets: 0,
						searchable: false,
						render: function ( data, type, full, row ) {
							return '<a href="#" class="a-koi-search-productop-component-table">' + data + '</a>';
						}
					}
                ]
			});

            // Modal show
            this.ready();
			this.$modalComponent.modal('show');
		},

		setProducto: function(e) {
			e.preventDefault();

	        var data = this.productospSearchTable.row( $(e.currentTarget).parents('tr') ).data(),
                productop = this.$inputContent.attr("data-productop");

            if( productop == 'true'){
                this.$inputContent.html('').append("<option value='"+data.id+"' selected>"+data.productop_nombre+"</option>").removeAttr('disabled');
            }else{
                this.$inputContent.val( data.id );
                this.$inputName.val( data.productop_nombre );
            }

			this.$modalComponent.modal('hide');
		},

		search: function(e) {
			e.preventDefault();

		    this.productospSearchTable.ajax.reload();
		},

		clear: function(e) {
			e.preventDefault();

            this.$searchCodigo.val('');
            this.$searchNombre.val('');

            this.productospSearchTable.ajax.reload();
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentSearchTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentSearchTerceroView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-search-tercero-component-tpl').html() || '') ),

		events: {
			'change input.tercero-koi-component': 'terceroChanged',
            'click .btn-koi-search-tercero-component-table': 'searchTercero',
            'click .btn-search-koi-search-tercero-component': 'search',
            'click .btn-clear-koi-search-tercero-component': 'clear',
            'click .a-koi-search-tercero-component-table': 'setTercero'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
            this.$modalComponent = this.$('#modal-search-component');
		},

		searchTercero: function(e) {
            e.preventDefault();
            var _this = this;

            // Render template
            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$searchNit = this.$('#koi_search_tercero_nit');
            this.$searchName = this.$('#koi_search_tercero_nombre');

            this.$tercerosSearchTable = this.$modalComponent.find('#koi-search-tercero-component-table');
			this.$inputContent = this.$("#"+$(e.currentTarget).attr("data-field"));
            this.$inputName = this.$("#"+this.$inputContent.attr("data-name"));
            this.$btnContact = this.$("#"+this.$inputContent.attr("data-contacto"));
            this.$inputOrden = this.$("#"+this.$inputContent.attr("data-orden2"));
            this.$inputFormapago = this.$("#"+this.$inputContent.attr("data-formapago"));
            this.$inputTiempop = this.$inputContent.attr("data-tiempop");

            /* Render in <a> dashboard */
            this.$fieldRender = this.$($(e.currentTarget)).attr("data-render");

            this.tercerosSearchTable = this.$tercerosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('terceros.index') ),
                    data: function( data ) {
                        data.tercero_nit = _this.$searchNit.val();
                        data.tercero_nombre = _this.$searchName.val();
                        data.tercero_tiempop = _this.$inputTiempop;
                    }
                },
                columns: [
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            // Render show tercero in dashboard
                            if (_this.$fieldRender == "show")
                            {
                                return '<a href='+ window.Misc.urlFull( Route.route('terceros.show', { terceros: full.id}))+'>' + data + '</a>';
                            }
                            return '<a href="#" class="a-koi-search-tercero-component-table">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6],
                        visible: false,
                        searchable: false
                    }
                ]
            });

            // Modal show
            this.ready();
            this.$modalComponent.modal('show');
        },

        setTercero: function(e) {
            e.preventDefault();

            var data = this.tercerosSearchTable.row( $(e.currentTarget).parents('tr') ).data();

            this.$inputContent.val( data.tercero_nit );
            this.$inputName.val( data.tercero_nombre );

            if(this.$inputOrden.length > 0) {
                this.$inputOrden.attr('data-tercero', data.id);
            }

            if(this.$inputFormapago.length > 0 || _.isNull(data.tercero_formapago) ) {
                this.$inputFormapago.val( data.tercero_formapago );
            }

            if(this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', data.id);
                this.$btnContact.attr('data-address-default', data.tercero_direccion);
                this.$btnContact.attr('data-address-nomenclatura-default', data.tercero_dir_nomenclatura);
                this.$btnContact.attr('data-municipio-default', data.tercero_municipio);
            }

            this.$modalComponent.modal('hide');
        },

        search: function(e) {
            e.preventDefault();

            this.tercerosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchNit.val('');
            this.$searchName.val('');

            this.tercerosSearchTable.ajax.reload();
        },

        terceroChanged: function(e) {
            var _this = this;

            this.$inputContent = $(e.currentTarget);
            this.$inputName = this.$("#"+$(e.currentTarget).attr("data-name"));
            this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
            this.$btnContact = this.$("#"+this.$inputContent.attr("data-contacto"));
            this.$inputOrden = this.$("#"+this.$inputContent.attr("data-orden2"));
            this.$inputTiempop = this.$inputContent.attr("data-tiempop");

            if(this.$btnContact.length > 0) {
                this.$btnContact.attr('data-tercero', '');
                this.$btnContact.attr('data-address-default', '');
                this.$btnContact.attr('ata-address-nomenclatura-default', '');
                this.$btnContact.attr('data-municipio-default', '');
            }

            if(this.$inputOrden.length > 0) {
                this.$inputOrden.attr('data-tercero', '');
            }

            var tercero = this.$inputContent.val(),
                tiempop = this.$inputTiempop;


            // Before eval clear data
            this.$inputName.val('');

            if(!_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '') {
                // Get tercero
                $.ajax({
                    url: window.Misc.urlFull(Route.route('terceros.search')),
                    type: 'GET',
                    data: { tercero_nit: tercero, tiempop_tercero: tiempop },
                    beforeSend: function() {
                        _this.$inputName.val('');
                        window.Misc.setSpinner( _this.$wraperConten );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.$wraperConten );
                    if(resp.success) {
                        if(!_.isUndefined(resp.tercero_nombre) && !_.isNull(resp.tercero_nombre)){
                            _this.$inputName.val(resp.tercero_nombre);
                        }
                        if(_this.$btnContact.length > 0) {
                            _this.$btnContact.attr('data-tercero', resp.id);
                            _this.$btnContact.attr('data-address-default', resp.tercero_direccion);
                            _this.$btnContact.attr('data-address-nomenclatura-default', resp.tercero_dir_nomenclatura);
                            _this.$btnContact.attr('data-municipio-default', resp.tercero_municipio);
                        }
                        if(_this.$inputOrden.length > 0) {
                            _this.$inputOrden.attr('data-tercero', resp.id);
                        }
                    }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		},

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
        }
    });


})(jQuery, this, this.document);

/**
* Class ComponentTerceroView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentTerceroView = Backbone.View.extend({

      	el: 'body',
        templateName: _.template( ($('#tercero-name-tpl').html() || '') ),
		events: {
			'change .change-nit-koi-component': 'nitChanged',
            'change .change-actividad-koi-component': 'actividadChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

        nitChanged: function(e) {
            var _this = this;

            // Reference to fields
            this.$dv = $("#"+$(e.currentTarget).attr("data-field"));
        	this.$wraperContent = this.$('#tercero-create');
            if(!this.$wraperContent.length) {
	            this.$modalComponent = this.$('#modal-add-resource-component');
	            this.$wraperContent = this.$modalComponent.find('.modal-body');
   			}

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.dv')),
                type: 'GET',
                data: { tercero_nit: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraperContent );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraperContent );
                if(resp.success) {
                    // Dv
                    _this.$dv.val(resp.dv);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wraperContent );
                alertify.error(thrownError);
            });
        },

        actividadChanged: function(e) {
            var _this = this;

            // Reference to fields
            this.$retecree = $("#"+$(e.currentTarget).attr("data-field"));
            this.$wraperContent = this.$('#tercero-create');
            if(!this.$wraperContent.length) {
                this.$modalComponent = this.$('#modal-add-resource-component');
                this.$wraperContent = this.$modalComponent.find('.modal-body');
            }

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.rcree')),
                type: 'GET',
                data: { tercero_actividad: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.$wraperContent );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.$wraperContent );
                if(resp.success) {
                    // % cree
                    if(!_.isUndefined(resp.rcree) && !_.isNull(resp.rcree)){
                        _this.$retecree.html(resp.rcree);
                    }
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.$wraperContent );
                alertify.error(thrownError);
            });
        }
    });


})(jQuery, this, this.document);

/**
* Class AcabadosProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-acabados-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object cotizacion5Model Model instance
        */
        addOne: function (cotizacion5Model) {
            var view = new app.AcabadosProductopCotizacionItemView({
                model: cotizacion5Model
            });
            cotizacion5Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class AcabadosProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#cotizacion-producto-acabado-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class AreasProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-areas-list',
        events: {
            'click .item-producto-areas-remove': 'removeOne',
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {
        },

        /**
        * Render view contact by model
        * @param Object cotizacion6Model Model instance
        */
        addOne: function (cotizacion6Model) {
            var view = new app.AreasProductopCotizacionItemView({
                model: cotizacion6Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cotizacion6Model.view = view;
            this.$el.append( view.render().el );

            // Totaliza
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * store
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Validar carrito temporal
            var valid = this.collection.validar( data );
            if(!valid.success) {
                alertify.error(valid.message);
                return;
            }

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var cotizacion6Model = new app.Cotizacion6Model();
            cotizacion6Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if( _.isUndefined(this.parameters.dataFilter.cotizacion2) ){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.collection.remove(model);
                    this.totalize();
                }
            }else{
                var reg = /[A-Za-z]/;
                if( !reg.test(resource) ){
                    this.areaDelete(model);
                }else{
                    if ( model instanceof Backbone.Model ) {
                        model.view.remove();
                        this.collection.remove(model);
                        this.totalize();
                    }
                }
            }
        },

        /**
        * modal confirm delete area
        */
        areaDelete: function(model, cotizacion2) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion6_nombre: model.get('cotizacion6_nombre'), cotizacion6_areap: model.get('areap_nombre')},
                    template: _.template( ($('#cotizacion-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar área',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        *Render totales the collection
        */
        totalize: function(){
            // Llamar funcion de calculateOrdenp2 del modelo Ordnep2
            this.parameters.model.trigger('calculateCotizacion2')

            // Render table total areas
            var data = this.collection.totalize();
            if(this.$total.length){
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-cotizacion6-producto') );
            }
        },
   });

})(jQuery, this, this.document);

/**
* Class AreassProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#cotizacion-producto-areas-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class CreateCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'submit #form-cotizaciones': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html( this.template(attributes) );
            this.$form = this.$('#form-cotizaciones');
            this.spinner = this.$('#spinner-main');

            this.ready();
        },

        /**
        * Event submit productop
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // createOrdenpView undelegateEvents
                if ( this.createCotizacionView instanceof Backbone.View ){
                    this.createCotizacionView.stopListening();
                    this.createCotizacionView.undelegateEvents();
                }

                // Redirect to edit cotizaciones
                Backbone.history.navigate(Route.route('cotizaciones.edit', { cotizaciones: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateCotizacion2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateCotizacion2View = Backbone.View.extend({

        el: '#cotizaciones-productos-create',
        template: _.template( ($('#add-cotizacion-producto-tpl').html() || '') ),
        events: {
            'change .calculate_formula': 'changeFormula',
            'ifChanged #cotizacion2_tiro': 'changedTiro',
            'ifChanged #cotizacion2_retiro': 'changedRetiro',
            'click .submit-cotizacion2': 'submitCotizacion2',
            'submit #form-cotizacion-producto': 'onStore',
            'click .submit-cotizacion6': 'submitCotizacion6',
            'change #cotizacion6_areap': 'changeAreap',
            'submit #form-cotizacion6-producto': 'onStoreCotizacion6',
            'change .event-price': 'calculateCotizacion2',
        },
        parameters: {
            data: {
                cotizacion2_productop: null
            }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-cotizacion-producto');
            this.maquinasProductopCotizacionList = new app.MaquinasProductopCotizacionList();
            this.materialesProductopCotizacionList = new app.MaterialesProductopCotizacionList();
            this.acabadosProductopCotizacionList = new app.AcabadosProductopCotizacionList();
            this.areasProductopCotizacionList = new app.AreasProductopCotizacionList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'calculateCotizacion2', this.calculateCotizacion2 );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$form = this.$('#form-cotizacion-producto');

            this.$inputFormula = null;
            this.$inputRenderFormula = null;
            this.$inputRound = null;

            // Inputs render round
            this.$inputFormulaPrecio = this.$('#cotizacion2_precio_formula');
            this.$inputFormulaTransporte = this.$('#cotizacion2_transporte_formula');
            this.$inputFormulaViaticos = this.$('#cotizacion2_viaticos_formula');

            // Inputs render round
            this.$inputRoundPrecio = this.$('#cotizacion2_precio_round');
            this.$inputRoundTranporte = this.$('#cotizacion2_transporte_round');
            this.$inputRoundViaticos = this.$('#cotizacion2_viaticos_round');

            // Inputs render formulas
            this.$inputPrecio = this.$('#cotizacion2_precio_venta');
            this.$inputTranporte = this.$('#cotizacion2_transporte');
            this.$inputViaticos = this.$('#cotizacion2_viaticos');

            // Tiro
            this.$inputYellow = this.$('#cotizacion2_yellow');
            this.$inputMagenta = this.$('#cotizacion2_magenta');
            this.$inputCyan = this.$('#cotizacion2_cyan');
            this.$inputKey = this.$('#cotizacion2_key');

            // Retiro
            this.$inputYellow2 = this.$('#cotizacion2_yellow2');
            this.$inputMagenta2 = this.$('#cotizacion2_magenta2');
            this.$inputCyan2 = this.$('#cotizacion2_cyan2');
            this.$inputKey2 = this.$('#cotizacion2_key2');

            // Ordenp6
            this.$formCotizacion6 = this.$('#form-cotizacion6-producto');
            this.$inputArea = this.$('#cotizacion6_nombre');
            this.$inputTiempo = this.$('#cotizacion6_tiempo');
            this.$inputValor = this.$('#cotizacion6_valor');

            // Inputs cuadro de informacion
            this.totalCotizacion2 = 0;
            this.tranporte = 0;
            this.viaticos = 0;
            this.precio = 0;
            this.areas = 0;
            this.cantidad = 1;

            // Inputs from form
            this.$precioCotizacion2 = this.$('#total-price');
            this.$cantidad = this.$('#cotizacion2_cantidad');
            this.$precio = this.$('#cotizacion2_precio_venta');
            this.$viaticos = this.$('#cotizacion2_viaticos');
            this.$transporte = this.$('#cotizacion2_transporte');

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');
            this.$infoareas = this.$('#info-areas');

            // Reference views
            this.calculateCotizacion2();
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.cotizacion2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.cotizacion2 = this.model.get('id');
                dataFilter.productop = this.model.get('cotizacion2_productop');
            }

            // Maquinas list
            this.maquinasProductopCotizacionListView = new app.MaquinasProductopCotizacionListView( {
                collection: this.maquinasProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.materialesProductopCotizacionListView = new app.MaterialesProductopCotizacionListView( {
                collection: this.materialesProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.acabadosProductopCotizacionListView = new app.AcabadosProductopCotizacionListView( {
                collection: this.acabadosProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Areasp list
            this.areasProductopCotizacionListView = new app.AreasProductopCotizacionListView( {
                collection: this.areasProductopCotizacionList,
                parameters: {
                    dataFilter: dataFilter,
                    model: this.model,
                    edit: true,
               }
            });
        },

        /**
        * Event calcule formula
        */
        changeFormula: function (e) {
        	var _this = this,
                inputformula = this.$(e.currentTarget).data('input');

            if( inputformula == 'P' || inputformula == 'RP'){
                this.$inputFormula = this.$inputFormulaPrecio;
                this.$inputRound = this.$inputRoundPrecio;
                this.$inputRenderFormula = this.$inputPrecio;

            }else if( inputformula == 'T' || inputformula == 'RT'){
                this.$inputFormula = this.$inputFormulaTransporte;
                this.$inputRound = this.$inputRoundTranporte;
                this.$inputRenderFormula = this.$inputTranporte;

            }else if( inputformula == 'V' || inputformula == 'RV'){
                this.$inputFormula = this.$inputFormulaViaticos;
                this.$inputRound = this.$inputRoundViaticos;
                this.$inputRenderFormula = this.$inputViaticos;

            }else{
                return;
            }

        	var formula = this.$inputFormula.val();
        	var round = this.$inputRound.val();

        	// sanitize input and replace
        	formula = formula.replaceAll("(","n");
        	formula = formula.replaceAll(")","m");
        	formula = formula.replaceAll("+","t");

        	// Eval formula
            $.ajax({
                url: window.Misc.urlFull(Route.route('cotizaciones.productos.formula')),
                type: 'GET',
                data: { equation: formula, round: round },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                _this.$inputRenderFormula.val(resp.precio_venta).trigger('change');
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
            	_this.$inputRenderFormula.val(0);
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        changedTiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow.iCheck('check');
                this.$inputMagenta.iCheck('check');
                this.$inputCyan.iCheck('check');
                this.$inputKey.iCheck('check');
            }else{
                this.$inputYellow.iCheck('uncheck');
                this.$inputMagenta.iCheck('uncheck');
                this.$inputCyan.iCheck('uncheck');
                this.$inputKey.iCheck('uncheck');
            }
        },

        changedRetiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow2.iCheck('check');
                this.$inputMagenta2.iCheck('check');
                this.$inputCyan2.iCheck('check');
                this.$inputKey2.iCheck('check');
            }else{
                this.$inputYellow2.iCheck('uncheck');
                this.$inputMagenta2.iCheck('uncheck');
                this.$inputCyan2.iCheck('uncheck');
                this.$inputKey2.iCheck('uncheck');
            }
        },

        /**
        * Event submit productop
        */
        submitCotizacion2: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.cotizacion6 = this.areasProductopCotizacionList.toJSON();
                this.model.save( data, {silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitCotizacion6: function (e) {
            this.$formCotizacion6.submit();
        },

        /**
        * Event Create Folder
        */
        onStoreCotizacion6: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopCotizacionList.trigger( 'store' , data );
            }
        },

        /**
        *   Event render input value
        **/
        changeAreap: function(e){
            var _this = this;
            id = this.$(e.currentTarget).val();

            if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('areasp.show', {areasp: id}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$inputArea.val('').attr('readonly', true);
                    _this.$inputTiempo.val('');
                    _this.$inputValor.val( resp.areap_valor );
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$inputArea.val('').attr('readonly', false);
                this.$inputTiempo.val('');
                this.$inputValor.val('');
            }
        },

        /**
        * Event calculate cotizacion
        **/
        calculateCotizacion2: function() {
            // Igualar variables y quitar el inputmask
            this.cantidad = parseInt( this.$cantidad.val() );
            this.tranporte = Math.round(parseFloat( this.$transporte.inputmask('unmaskedvalue') ) / parseFloat( this.cantidad ));
            this.viaticos = Math.round(parseFloat( this.$viaticos.inputmask('unmaskedvalue') ) / parseFloat( this.cantidad ));
            this.areas = Math.round(parseFloat( this.areasProductopCotizacionList.totalize()['total'] ) / parseFloat( this.cantidad ));
            this.precio = parseFloat( this.$precio.inputmask('unmaskedvalue') );

            // Cuadros de informacion
            this.$infoprecio.empty().html( window.Misc.currency( this.precio ) );
            this.$infoviaticos.empty().html( window.Misc.currency( this.viaticos ) );
            this.$infotransporte.empty().html( window.Misc.currency( this.tranporte ) );
            this.$infoareas.empty().html( window.Misc.currency( this.areas ) );

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            this.totalCotizacion2 = this.precio + this.tranporte + this.viaticos + this.areas;
            this.$precioCotizacion2.val( this.totalCotizacion2 );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
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

                // Redirect to cotizacion
                window.Misc.redirect( window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: this.model.get('cotizacion2_cotizacion') })) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class EditCotizacionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-create',
        template: _.template( ($('#add-cotizacion-tpl').html() || '') ),
        events: {
            'click .submit-cotizacion': 'submitCotizacion',
            'click .close-cotizacion': 'closeCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion',
            'click .generate-cotizacion': 'generateCotizacion',
            'click .export-cotizacion': 'exportCotizacion',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-cotizaciones': 'onStore',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.productopCotizacionList = new app.ProductopCotizacionList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.$form = this.$('#form-cotizaciones');
            this.spinner = this.$('#spinner-main');

            // Reference views and ready
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView( {
                collection: this.productopCotizacionList,
                parameters: {
                    edit: true,
                    iva: this.model.get('cotizacion1_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        'cotizacion2_cotizacion': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit productop
        */
        submitCotizacion: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create cotizacion
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        changeTypeProduct: function(e) {
            var _this = this;
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).attr('disabled', 'disabled');
                    _this.$subtypeproduct.empty().val(0).removeAttr('disabled');
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0).attr('disabled', 'disabled');
                this.$product.empty().val(0).attr('disabled', 'disabled');
            }
        },

        changeSubtypeProduct: function(e) {
            var _this = this;
                subtypeproduct = this.$(e.currentTarget).val();
                typeproduct = this.$('#typeproductop').val();

            if( typeof(subtypeproduct) !== 'undefined' && !_.isUndefined(subtypeproduct) && !_.isNull(subtypeproduct) && subtypeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: {
                        subtypeproduct: subtypeproduct,
                        typeproduct: typeproduct
                    },
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).removeAttr('disabled');
                    _this.$product.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$product.append("<option value="+item.id+">"+item.productop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.model.get('id') })), '_blank');
        },

        /**
        * Close cotizacion
        */
        closeCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar cotización',
                    onConfirm: function () {
                        // Close cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.cerrar', { cotizaciones: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.spinner );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.spinner );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.show', { cotizaciones: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Clone cotizacion
        */
        cloneCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route =  window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: this.model.get('id') }) ),
                data = { cotizacion_codigo: _this.model.get('cotizacion_codigo') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Generate cotizacion
        */
        generateCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route =  window.Misc.urlFull( Route.route('cotizaciones.generar', { cotizaciones: this.model.get('id') }) ),
                data = { cotizacion_codigo: _this.model.get('cotizacion_codigo'), cotizacion_referencia: _this.model.get('cotizacion1_referencia') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-generate-confirm-tpl').html() || '') ),
                    titleConfirm: 'Generar orden de producción',
                    onConfirm: function () {
                        // Generate orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.generar', { cotizaciones: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.spinner );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.spinner );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.orden_id })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit cotizacion
                window.Misc.redirect( window.Misc.urlFull( Route.route('cotizaciones.edit', { cotizaciones: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainCotizacionesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainCotizacionesView = Backbone.View.extend({

        el: '#cotizaciones-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },


        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$cotizacionesSearchTable = this.$('#cotizaciones-search-table');
            this.$searchcotizacionCotizacion = this.$('#searchcotizacion_numero');
            this.$searchcotizacionTercero = this.$('#searchcotizacion_tercero');
            this.$searchcotizacionTerceroName = this.$('#searchcotizacion_tercero_nombre');
            this.$searchcotizacionEstado = this.$('#searchcotizacion_estado');
            this.$searchcotizacionReferencia = this.$('#searchcotizacion_referencia');
            this.$searchcotizacionProductop = this.$('#searchcotizacion_productop');

            this.cotizacionesSearchTable = this.$cotizacionesSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('cotizaciones.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.cotizacion_numero = _this.$searchcotizacionCotizacion.val();
                        data.cotizacion_tercero_nit = _this.$searchcotizacionTercero.val();
                        data.cotizacion_tercero_nombre = _this.$searchcotizacionTerceroName.val();
                        data.cotizacion_estado = _this.$searchcotizacionEstado.val();
                        data.cotizacion_referencia = _this.$searchcotizacionReferencia.val();
                        data.cotizacion_productop = _this.$searchcotizacionProductop.val();
                    }
                },
                columns: [
                    { data: 'cotizacion_codigo', name: 'cotizacion_codigo' },
                    { data: 'cotizacion1_ano', name: 'cotizacion1_ano' },
                    { data: 'cotizacion1_numero', name: 'cotizacion1_numero' },
                    { data: 'cotizacion1_fecha_inicio', name: 'cotizacion1_fecha_inicio' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' }
                ],
                order: [
                    [ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('cotizaciones.show', {cotizaciones: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: [1, 2],
                        visible: false,
                        width: '10%',
                    },
                    {
                        targets: 3,
                        width: '10%',
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.cotizacion1_abierta) ) {
                        $(row).css( {"color":"#00a65a"} );
                    }else if ( parseInt(data.cotizacion1_anulada) ) {
                        $(row).css( {"color":"red"} );
                    }else{
                        $(row).css( {"color":"black"} );
                    }
                }
            });
        },

        search: function(e) {
            e.preventDefault();

            this.cotizacionesSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchcotizacionCotizacion.val('');
            this.$searchcotizacionTercero.val('');
            this.$searchcotizacionTerceroName.val('');
            this.$searchcotizacionEstado.val('');
            this.$searchcotizacionReferencia.val('');
            this.$searchcotizacionProductop.val('').trigger('change');

            this.cotizacionesSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);

/**
* Class MaquinasProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinasProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-maquinas-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object cotizacion3Model Model instance
        */
        addOne: function (cotizacion3Model) {
            var view = new app.MaquinasProductopCotizacionItemView({
                model: cotizacion3Model
            });
            cotizacion3Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class MaquinasProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinasProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#cotizacion-producto-maquina-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class MaterialesProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-producto-materiales-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object cotizacion4Model Model instance
        */
        addOne: function (cotizacion4Model) {
            var view = new app.MaterialesProductopCotizacionItemView({
                model: cotizacion4Model
            });
            cotizacion4Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class MaterialesProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#cotizacion-producto-material-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class ProductopCotizacionListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopCotizacionListView = Backbone.View.extend({

        el: '#browse-cotizacion-productop-list',
        events: {
            'click .item-cotizacion-producto-remove': 'removeOne',
            'click .item-cotizacion-producto-clone': 'cloneOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            iva: 0,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$unidades = this.$('#subtotal-cantidad');
            this.$facturado = this.$('#subtotal-facturado');
            this.$subtotal = this.$('#subtotal-total');
            this.$iva = this.$('#iva-total');
            this.$total = this.$('#total-total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {cotizacion2_cotizacion: this.parameters.dataFilter.cotizacion2_cotizacion}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {
        },

        /**
        * Render view contact by model
        * @param Object cotizacion2Model Model instance
        */
        addOne: function (cotizacion2Model) {
            var view = new app.ProductopCotizacionItemView({
                model: cotizacion2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            cotizacion2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            // Function confirm delete item
            this.confirmDelete( model );
        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { producto_id: model.get('id'), producto_nombre: model.get('productop_nombre') },
                    template: _.template( ($('#cotizacion-productop-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar producto',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);

                                        // Update total
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Event clone item
        */
        cloneOne: function (e) {
            e.preventDefault();

            var _this = this,
                resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                route = window.Misc.urlFull( Route.route('cotizaciones.productos.clonar', { productos: model.get('id') }) ),
                data = { cotizacion2_codigo: model.get('id'), productop_nombre: model.get('productop_nombre') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#cotizacion-productop-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar producto cotización',
                    onConfirm: function () {
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.parameters.wrapper,
                            'callback': (function ( _this ) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.productos.show', { productos: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$unidades.length) {
                this.$unidades.html( data.unidades );
            }

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
            }

            if(this.$subtotal.length) {
                this.$subtotal.html( window.Misc.currency(data.subtotal) );
            }

            var iva = data.subtotal * ( this.parameters.iva / 100);
            if(this.$iva.length) {
                this.$iva.html( window.Misc.currency(iva) );
            }

            var total = data.subtotal + iva;
            if(this.$total.length) {
                this.$total.html( window.Misc.currency(total) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class ProductopCotizacionItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopCotizacionItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#cotizacion-producto-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class ShowCotizacionView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowCotizacionView = Backbone.View.extend({

        el: '#cotizaciones-show',
        events: {
            'click .export-cotizacion': 'exportCotizacion',
            'click .open-cotizacion': 'openCotizacion',
            'click .clone-cotizacion': 'cloneCotizacion'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Recuperar iva
            this.$iva = this.$('#cotizacion1_iva');

            // Attributes
            this.productopCotizacionList = new app.ProductopCotizacionList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopCotizacionListView = new app.ProductopCotizacionListView( {
                collection: this.productopCotizacionList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-cotizacion'),
                    iva: this.$iva.val(),
                    dataFilter: {
                        'cotizacion2_cotizacion': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Open cotizacion
        */
        openCotizacion: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { cotizacion_codigo: _this.model.get('cotizacion_codigo') },
                    template: _.template( ($('#cotizacion-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir cotización',
                    onConfirm: function () {
                        // Open cotizacion
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('cotizaciones.abrir', { cotizaciones: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });
            cancelConfirm.render();
        },

        /**
        * Clone cotizacion
        */
        cloneCotizacion: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('cotizaciones.clonar', { cotizaciones: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#cotizacion-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar cotización',
                    onConfirm: function () {
                        // Clone cotizacion
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.$el,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('cotizaciones.edit', { cotizaciones: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * export to PDF
        */
        exportCotizacion: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('cotizaciones.exportar', { cotizaciones: this.model.get('id') })), '_blank');
        }
    });

})(jQuery, this, this.document);

/**
* Class MainDepartamentoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDepartamentoView = Backbone.View.extend({
        el: '#departamentos-main',
        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$departamentosSearchTable = this.$('#departamentos-search-table');

            this.$departamentosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('departamentos.index') ),
                columns: [
                    { data: 'departamento_codigo', name: 'departamento_codigo' },
                    { data: 'departamento_nombre', name: 'departamento_nombre'}
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateDocumentoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateDocumentoView = Backbone.View.extend({

        el: '#documento-create',
        template: _.template( ($('#add-documento-tpl').html() || '') ),
        events: {
            'submit #form-documento': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-documento');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

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

                window.Misc.redirect( window.Misc.urlFull( Route.route('documentos.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
 * Class MainDocumentosView
 * @author KOI || @dropecamargo
 * @link http://koi-ti.com
 */

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainDocumentosView = Backbone.View.extend({
        el: '#documentos-main',
        /**
         * Constructor Method
         */
        initialize: function () {

            this.$documentosSearchTable = this.$('#documentos-search-table');

            this.$documentosSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('documentos.index') ),
                columns: [
                    { data: 'documento_codigo', name: 'documento_codigo' },
                    { data: 'documento_nombre', name: 'documento_nombre' },
                    { data: 'folder_codigo', name: 'folder_codigo' },
                    { data: 'documento_actual', name: 'documento_actual' },
                    { data: 'documento_nif', name: 'documento_nif' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nuevo documento',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('documentos.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '7%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('documentos.show', {documentos: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '63%'
                    },
                    {
                        targets: 2,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            if(!_.isNull(full.folder_codigo) && !_.isUndefined(full.folder_codigo)) {
                                return '<a href="'+ window.Misc.urlFull( Route.route('folders.show', {folders: full.folder_id }) )  +'">' + data + '</a>';
                            }
                            return '';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateEmpresaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateEmpresaView = Backbone.View.extend({

        el: '#empresa-create',
        template: _.template( ($('#add-company-tpl').html() || '') ),
        templateName: _.template( ($('#tercero-name-tpl').html() || '') ),
        events: {
            'change input#tercero_nit': 'nitChanged',
            'change select#tercero_persona': 'personaChanged',
            'change select#tercero_actividad': 'actividadChanged',
            'submit #form-create-empresa': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-empresa');

            // Events
            this.listenTo( this.model, 'change:id', this.render );
            this.listenTo( this.model, 'change:tercero_persona', this.renderName );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // Reference to fields
            this.$dv = this.$('#tercero_digito');
            this.$retecree = this.$('#tercero_retecree');

            this.ready();
        },

        /**
        * render name
        */
        renderName: function (model, value, opts) {
            this.$('#content-render-name').html( this.templateName(this.model.toJSON()) );
            this.ready();
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

        nitChanged: function(e) {
            var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.dv')),
                type: 'GET',
                data: { tercero_nit: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // Dv
                    _this.$dv.val(resp.dv);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        personaChanged: function(e) {
        	this.model.set({ tercero_persona: $(e.currentTarget).val() });
        },

        actividadChanged: function(e) {
            var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('terceros.rcree')),
                type: 'GET',
                data: { tercero_actividad: $(e.currentTarget).val() },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    // % cree
                    if(!_.isUndefined(resp.rcree) && !_.isNull(resp.rcree)){
                        _this.$retecree.html(resp.rcree);
                    }
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true} );
            }
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

                alertify.success('Empresa fue actualizada con éxito.');
	     	}
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFacturaView = Backbone.View.extend({

        el: '#factura-create',
        template: _.template(($('#add-facturas-tpl').html() || '') ),
        templateDetail: _.template(($('#add-detail-factura').html() || '') ),
        events: {
            'click .submit-factura' :'submitFactura',
            'submit #form-factura' :'onStore',
            'submit #form-detail-factura' :'onStoreItem',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-factura');
            this.detalleFactura2List = new app.DetalleFactura2List();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            
            // Render Detail factura
            this.$renderDetail = this.$('#render-detail');
            this.$renderDetail.html( this.templateDetail({}) );

            this.$form = this.$('#form-factura');
            this.$formDetail = this.$('#form-detail-factura');

            this.referenceView();
            this.ready();
        },

        /**
        * Event submit factura1
        */
        submitFactura: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create facturas
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                    data.detail = window.Misc.formToJson( this.$formDetail );

                this.model.save( data, {patch: true, silent: true} );
            }   
        },  

         /**
        * reference to views
        */
        referenceView: function(){
            // Detalle factura list
            this.detalleFacturaView = new app.DetalleFacturaView({
                collection: this.detalleFactura2List,
                parameters: {
                    edit: false,
                    dataFilter: {
                        'factura1_orden': this.model.get('id')
                    }
                }
            });
        },

        onStoreItem: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.detalleFactura2List.trigger( 'store', data );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
            
            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
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

                // CreateFacturaView undelegateEvents
                if ( this.createFacturaView instanceof Backbone.View ){
                    this.createFacturaView.stopListening();
                    this.createFacturaView.undelegateEvents();
                }

                window.Misc.redirect( window.Misc.urlFull( Route.route('facturas.show', { facturas: resp.id})) );
            }
        }
    });
})(jQuery, this, this.document);

/**
* Class DetalleFacturaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturaItemView = Backbone.View.extend({

        tagName: 'tr',
        className: 'form-group',
        template: _.template( ($('#facturado-item-list-tpl').html() || '') ),
        parameters: {
            call: null,
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            if(this.parameters.call == 'show'){
                this.template = _.template( ($('#add-factura-item-tpl').html() || '') );
            }

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class DetalleFacturaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturaView = Backbone.View.extend({

        el: '#browse-detalle-factura-list',
        events: {
            'click .item-detail-factura-remove': 'removeOne',
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // References
            this.$facturado = this.$('#subtotal-facturado');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (factura2Model) {
            var view = new app.DetalleFacturaItemView({
                model: factura2Model,
                parameters:{
                    call: this.parameters.call,
                }
            });
            factura2Model.view = view;
            this.$el.append( view.render().el );

            //totalize actually in collection
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * store
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Validate duplicate store 
            var result = this.collection.validar( data );
            if( !result.success ){
                alertify.error( result.error );
                return;                
            }

            // Set Spinner
            window.Misc.setSpinner( this.el );

            // Add model in collection
            var factura2Model = new app.Factura2Model();
            factura2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.el );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.el );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource");
            var model = this.collection.get(resource);

            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);
            }
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
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
                
                $('#factura1_orden').val('');
                $('#factura1_orden_beneficiario').val('');
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class MainFacturasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturasView = Backbone.View.extend({

        el: '#facturas-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },


        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$facturasSearchTable = this.$('#facturas-search-table');

            // References
            this.$searchfacturaNumero = this.$('#searchfactura_numero');
            this.$searchfacturaTercero = this.$('#searchfactura_tercero');
            this.$searchfacturaTerceroNombre = this.$('#searchfactura_tercero_nombre');

            this.facturasSearchTable = this.$facturasSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturas.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.factura1_numero = _this.$searchfacturaNumero.val();
                        data.tercero_nit = _this.$searchfacturaTercero.val();
                        data.tercero_nombre = _this.$searchfacturaTerceroNombre.val();
                    }
                },
                columns: [
                    { data: 'factura1_numero', name: 'factura1_numero' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'factura1_tercero' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturas.show', {facturas: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                    {
                        targets: 1,
                        width: '5%'
                    },
                    {
                        targets: 2,
                        width: '15%'
                    },
                ]
            });
        },

        search: function(e) {
            e.preventDefault();

            this.facturasSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchfacturaNumero.val('');
            this.$searchfacturaTercero.val('');
            this.$searchfacturaTerceroNombre.val('');

            this.facturasSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);

/**
* Class ShowFacturaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturaView = Backbone.View.extend({

        el: '#factura-show',
        events: {
            'click .export-factura': 'exportFactura',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.detalleFactura2List = new app.DetalleFactura2List();
            this.detalleFactura4List = new app.DetalleFactura4List();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.factura2ListView = new app.DetalleFacturaView({
                collection: this.detalleFactura2List,
                parameters: {
                    edit: false,
                    call: 'show',
                    dataFilter: {
                        factura2: this.model.get('id')
                    }
                }
            });

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFactura4List,
                parameters: {
                    edit: false,
                    template: _.template( ($('#add-detalle-factura-tpl').html() || '') ),
                    call: 'factura',
                    dataFilter: {
                        factura1_id: this.model.get('id')
                    }
                }
            });
        },

        /**
        * export to PDF
        */
        exportFactura: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull( Route.route('facturas.exportar', { facturas: this.model.get('id') })) );
        }
    });

})(jQuery, this, this.document);

/**
* Class DetalleFacturapItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturapItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#facturap-item-list-tpl').html() || '') ),
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class DetalleFacturapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DetalleFacturapView = Backbone.View.extend({

        el: '#browse-detalle-facturap-list',
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.confCollection = { reset: true, data: {} };

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            if( !_.isUndefined(this.parameters.dataFilter) && !_.isNull(this.parameters.dataFilter) ){
                this.confCollection.data = this.parameters.dataFilter;
                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view contact by model
        * @param Object detallePedidocModel Model instance
        */
        addOne: function (facturap2Model) {
            var view = new app.DetalleFacturapItemView({
                model: facturap2Model,
            });
            facturap2Model.view = view;
            this.$el.append( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);

/**
* Class MainFacturaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainFacturaspView = Backbone.View.extend({

        el: '#facturasp-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$facturaspSearchTable = this.$('#facturasp-search-table');

            // References
            this.$searchfacturapReferencia = this.$('#searchfacturap_referencia');
            this.$searchfacturapFecha = this.$('#searchfacturap_fecha');
            this.$searchfacturapTercero = this.$('#searchfacturap_tercero');
            this.$searchfacturapTerceroNombre = this.$('#searchfacturap_tercero_nombre');
            
            this.facturaspSearchTable = this.$facturaspSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('facturap.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.referencia = _this.$searchfacturapReferencia.val();
                        data.facturap_fecha = _this.$searchfacturapFecha.val();
                        data.tercero_nit = _this.$searchfacturapTercero.val();
                        data.tercero_nombre = _this.$searchfacturapTerceroNombre.val();
                    }
                },
                columns: [ 
                    { data: 'id', name: 'id' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' },
                    { data: 'facturap1_factura', name: 'facturap1_factura' },
                    { data: 'facturap1_fecha', name: 'facturap1_fecha' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '5%',
                        render: function ( data, type, full, row ) {
                           return '<a href="'+ window.Misc.urlFull( Route.route('facturap.show', {facturap: full.id }) )  +'">' + data + '</a>';
                        },
                    },
                ]
            });
        },

        search: function(e) {
            e.preventDefault();

            this.facturaspSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchfacturapReferencia.val('');
            this.$searchfacturapFecha.val('');
            this.$searchfacturapTercero.val('');
            this.$searchfacturapTerceroNombre.val('');

            this.facturaspSearchTable.ajax.reload();
        },
    });
})(jQuery, this, this.document);

/**
* Class ShowFacturaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowFacturapView = Backbone.View.extend({

        el: '#facturap-show',

        /**
        * Constructor Method
        */
        initialize : function() {

            // Model exist
            if( this.model.id != undefined ) {
                this.cuotasFPList = new app.CuotasFPList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle factura list
            this.detalleFacturapView = new app.DetalleFacturapView({
                collection: this.cuotasFPList,
                parameters: {
                    edit: false,
                    dataFilter: {
                        facturap1: this.model.get('id')
                    }
                }
            });
        },

    });

})(jQuery, this, this.document);

/**
* Class CreateFolderView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateFolderView = Backbone.View.extend({

        el: '#folder-create',
        template: _.template( ($('#add-folder-tpl').html() || '') ),
        events: {
            'submit #form-folder': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-folder');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('folders.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/*
 * Class MainfoldersView
 * @author KOI || @dropecamargo
 * @link http://koi-ti.com
 **/

//global app blackbone
app || (app={});

(function ($, window, document, undefined) {

    app.MainFoldersView = Backbone.View.extend({
        el: '#folders-main',
        /*
         * Constructor method
         */
        initialize: function () {

            this.$foldersSearchTable = this.$('#folders-search-table');

            this.$foldersSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('folders.index') ),
                columns: [
                    { data: 'folder_codigo', name: 'folder_codigo' },
                    { data: 'folder_nombre', name: 'folder_nombre' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Agregar Folder',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect(window.Misc.urlFull( Route.route('folders.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('folders.show', {folders: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);
/**
* Class CreateGrupoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateGrupoView = Backbone.View.extend({

        el: '#grupos-create',
        template: _.template( ($('#add-grupo-tpl').html() || '') ),
        events: {
            'submit #form-grupos': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-grupo');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('grupos.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainGruposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainGruposView = Backbone.View.extend({

        el: '#grupos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$gruposSearchTable = this.$('#grupos-search-table');

            this.$gruposSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('grupos.index') ),
                columns: [
                    { data: 'grupo_codigo', name: 'grupo_codigo' },
                    { data: 'grupo_nombre', name: 'grupo_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo grupo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('grupos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('grupos.show', {grupos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class AppRouter  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserLoginView = Backbone.View.extend({

        el: '#login-box',

        /**
        * Constructor Method
        */
        initialize : function() {
 
            //Init Attributes 
            this.$loginForm = $('#form-login-account');
            this.$loginForm.validator();
        },

        /*
        * Render View Element
        */
        render: function(){
            //
        }
    });


})(jQuery, this, this.document);

/**
* Class CreateMaquinapView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateMaquinapView = Backbone.View.extend({

        el: '#maquinasp-create',
        template: _.template( ($('#add-maquinap-tpl').html() || '') ),
        events: {
            'submit #form-maquinasp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-maquinap');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('maquinasp.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainMaquinaspView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMaquinaspView = Backbone.View.extend({

        el: '#maquinasp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$maquinaspSearchTable = this.$('#maquinasp-search-table');

            this.$maquinaspSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('maquinasp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'maquinap_nombre', name: 'maquinap_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva máquina',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('maquinasp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('maquinasp.show', {maquinasp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateMaterialpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateMaterialpView = Backbone.View.extend({

        el: '#materialesp-create',
        template: _.template( ($('#add-materialp-tpl').html() || '') ),
        events: {
            'submit #form-materialesp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-materialp');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('materialesp.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainMaterialespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMaterialespView = Backbone.View.extend({

        el: '#materialesp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$materialespSearchTable = this.$('#materialesp-search-table');

            this.$materialespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('materialesp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'materialp_nombre', name: 'materialp_nombre' },
                    { data: 'tipomaterialp_nombre', name: 'tipomaterialp_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo material',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('materialesp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('materialesp.show', {materialesp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class MainModuloView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainModuloView = Backbone.View.extend({

        el: '#modulos-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$modulosSearchTable = this.$('#modulos-search-table');
            this.$modulosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('modulos.index') ),
                columns: [
                    { data: 'display_name', name: 'display_name'},
                    { data: 'name', name: 'name'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%'
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class MainMunicipioView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainMunicipioView = Backbone.View.extend({

        el: '#municipios-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$municipiosSearchTable = this.$('#municipios-search-table');

            this.$municipiosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('municipios.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'departamento_codigo', name: 'koi_departamento.departamento_codigo'},
                    { data: 'departamento_nombre', name: 'departamento_nombre'},
                    { data: 'municipio_codigo', name: 'municipio_codigo' },
                    { data: 'municipio_nombre', name: 'municipio_nombre'},
                    { data: 'departamento_id', name: 'departamento_id'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%'
                    },
                    {
                        targets: 1,
                        width: '35%'
                    },
                    {
                        targets: 2,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('departamentos.show', {departamentos: full.departamento_id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '35%'
                    },
                    {
                        targets: 4,
                        visible: false,
                        searchable: false
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class AcabadosProductopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosProductopListView = Backbone.View.extend({

        el: '#browse-orden-producto-acabados-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp5Model Model instance
        */
        addOne: function (ordenp5Model) {
            var view = new app.AcabadosProductopItemView({
                model: ordenp5Model
            });
            ordenp5Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class AcabadosProductopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosProductopItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#orden-producto-acabado-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class AreasProductopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopListView = Backbone.View.extend({

        el: '#browse-orden-producto-areas-list',
        events: {
            'click .item-producto-areas-remove': 'removeOne',
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$total = this.$('#total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {
        },

        /**
        * Render view contact by model
        * @param Object ordenp6Model Model instance
        */
        addOne: function (ordenp6Model) {
            var view = new app.AreasProductopItemView({
                model: ordenp6Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            ordenp6Model.view = view;
            this.$el.append( view.render().el );

            // Totaliza
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * store
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Validar carrito temporal
            var valid = this.collection.validar( data );
            if(!valid.success) {
                alertify.error(valid.message);
                return;
            }

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var ordenp6Model = new app.Ordenp6Model();
            ordenp6Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource);

            if( _.isUndefined(this.parameters.dataFilter.orden2) ){
                if ( model instanceof Backbone.Model ) {
                    model.view.remove();
                    this.collection.remove(model);
                    this.totalize();
                }
            }else{
                var reg = /[A-Za-z]/;
                if( !reg.test(resource) ){
                    this.areaDelete(model);
                }else{
                    if ( model instanceof Backbone.Model ) {
                        model.view.remove();
                        this.collection.remove(model);
                        this.totalize();
                    }
                }
            }
        },

        /**
        * modal confirm delete area
        */
        areaDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden6_nombre: model.get('orden6_nombre'), orden6_areap: model.get('areap_nombre')},
                    template: _.template( ($('#orden-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar área',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        *Render totales the collection
        */
        totalize: function(){
            // Llamar funcion de calculateOrdenp2 del modelo Ordnep2
            this.parameters.model.trigger('calculateOrdenp2');

            var data = this.collection.totalize();
            if(this.$total.length) {
                this.$total.empty().html( window.Misc.currency( data.total ) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-ordenp6-producto') );
            }
        },
   });

})(jQuery, this, this.document);

/**
* Class AreasProductopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasProductopItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#orden-producto-areas-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class CreateOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenpView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-ordenp-tpl').html() || '') ),
        events: {
            'click .submit-ordenp': 'submitOrdenp',
            'submit #form-ordenes': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html( this.template(attributes) );
            this.$form = this.$('#form-ordenes');
            this.spinner = this.$('#spinner-main');

            this.ready();
        },

        /**
        * Event submit productop
        */
        submitOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // createOrdenpView undelegateEvents
                if ( this.createOrdenpView instanceof Backbone.View ){
                    this.createOrdenpView.stopListening();
                    this.createOrdenpView.undelegateEvents();
                }

                // Redirect to edit orden
                Backbone.history.navigate(Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateOrdenp2View  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateOrdenp2View = Backbone.View.extend({

        el: '#ordenes-productos-create',
        template: _.template( ($('#add-orden-producto-tpl').html() || '') ),
        events: {
            'change .calculate_formula': 'changeFormula',
            'ifChanged #orden2_tiro': 'changedTiro',
            'ifChanged #orden2_retiro': 'changedRetiro',
            'click .submit-ordenp2': 'submitOrdenp2',
            'submit #form-orden-producto': 'onStore',
            'click .submit-ordenp6': 'submitOrdenp6',
            'submit #form-ordenp6-producto': 'onStoreOrdenp6',
            'change #orden6_areap': 'changeAreap',
            'change .event-price': 'calculateOrdenp2',
        },
        parameters: {
            data: {
                orden2_productop: null
            }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-orden-producto');
            this.maquinasProductopList = new app.MaquinasProductopList();
            this.materialesProductopList = new app.MaterialesProductopList();
            this.acabadosProductopList = new app.AcabadosProductopList();
            this.areasProductopList = new app.AreasProductopList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'calculateOrdenp2', this.calculateOrdenp2 );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );
            this.$form = this.$('#form-orden-producto');

            this.$inputFormula = null;
            this.$inputRenderFormula = null;
            this.$inputRound = null;

            // Inputs render round
            this.$inputFormulaPrecio = this.$('#orden2_precio_formula');
            this.$inputFormulaTransporte = this.$('#orden2_transporte_formula');
            this.$inputFormulaViaticos = this.$('#orden2_viaticos_formula');

            // Inputs render round
            this.$inputRoundPrecio = this.$('#orden2_precio_round');
            this.$inputRoundTranporte = this.$('#orden2_transporte_round');
            this.$inputRoundViaticos = this.$('#orden2_viaticos_round');

            // Inputs render formulas
            this.$inputPrecio = this.$('#orden2_precio_venta');
            this.$inputTranporte = this.$('#orden2_transporte');
            this.$inputViaticos = this.$('#orden2_viaticos');

            this.$inputFormula = this.$('#orden2_precio_formula');
            this.$inputRound = this.$('#orden2_round_formula');
            this.$inputPrecio = this.$('#orden2_precio_venta');

            // Tiro
            this.$inputYellow = this.$('#orden2_yellow');
            this.$inputMagenta = this.$('#orden2_magenta');
            this.$inputCyan = this.$('#orden2_cyan');
            this.$inputKey = this.$('#orden2_key');

            // Retiro
            this.$inputYellow2 = this.$('#orden2_yellow2');
            this.$inputMagenta2 = this.$('#orden2_magenta2');
            this.$inputCyan2 = this.$('#orden2_cyan2');
            this.$inputKey2 = this.$('#orden2_key2');

            // Ordenp6
            this.$formOrdenp6 = this.$('#form-ordenp6-producto');
            this.$inputArea = this.$('#orden6_nombre');
            this.$inputTiempo = this.$('#orden6_tiempo');
            this.$inputValor = this.$('#orden6_valor');

            // Inputs cuadro de informacion
            this.totalOrdenp2 = 0;
            this.tranporte = 0;
            this.viaticos = 0;
            this.precio = 0;
            this.areas = 0;
            this.cantidad = 1;

            this.$precioOrdenp2 = this.$('#total-price');
            this.$cantidad = this.$('#orden2_cantidad');
            this.$precio = this.$('#orden2_precio_venta');
            this.$viaticos = this.$('#orden2_viaticos');
            this.$transporte = this.$('#orden2_transporte');

            // Informacion Cotizacion
            this.$infoprecio = this.$('#info-precio');
            this.$infoviaticos = this.$('#info-viaticos');
            this.$infotransporte = this.$('#info-transporte');
            this.$infoareas = this.$('#info-areas');

            // Reference views
            this.calculateOrdenp2();
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            var dataFilter = { productop: this.parameters.data.orden2_productop };

            // Model exist
            if( this.model.id != undefined ) {
                dataFilter.orden2 = this.model.get('id');
                dataFilter.productop = this.model.get('orden2_productop');
            }

            // Maquinas list
            this.maquinasProductopListView = new app.MaquinasProductopListView( {
                collection: this.maquinasProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.materialesProductopListView = new app.MaterialesProductopListView( {
                collection: this.materialesProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Materiales list
            this.acabadosProductopListView = new app.AcabadosProductopListView( {
                collection: this.acabadosProductopList,
                parameters: {
                    dataFilter: dataFilter
               }
            });

            // Areas list
            this.areasProductopListView = new app.AreasProductopListView( {
                collection: this.areasProductopList,
                parameters: {
                    dataFilter: dataFilter,
                    model: this.model,
                    edit: true
               }
            });
        },

        /**
        * Event calcule formula
        */
        changeFormula: function (e) {
            var _this = this,
                inputformula = this.$(e.currentTarget).data('input');

            if( inputformula == 'P' || inputformula == 'RP'){
                this.$inputFormula = this.$inputFormulaPrecio;
                this.$inputRound = this.$inputRoundPrecio;
                this.$inputRenderFormula = this.$inputPrecio;

            }else if( inputformula == 'T' || inputformula == 'RT'){
                this.$inputFormula = this.$inputFormulaTransporte;
                this.$inputRound = this.$inputRoundTranporte;
                this.$inputRenderFormula = this.$inputTranporte;

            }else if( inputformula == 'V' || inputformula == 'RV'){
                this.$inputFormula = this.$inputFormulaViaticos;
                this.$inputRound = this.$inputRoundViaticos;
                this.$inputRenderFormula = this.$inputViaticos;

            }else{
                return;
            }

        	var formula = this.$inputFormula.val();
        	var round = this.$inputRound.val();

        	// sanitize input and replace
        	formula = formula.replaceAll("(","n");
        	formula = formula.replaceAll(")","m");
        	formula = formula.replaceAll("+","t");

        	// Eval formula
            $.ajax({
                url: window.Misc.urlFull(Route.route('ordenes.productos.formula')),
                type: 'GET',
                data: { equation: formula, round: round },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                _this.$inputRenderFormula.val(resp.precio_venta).trigger('change');
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                _this.$inputRenderFormula.val(0);
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        changedTiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow.iCheck('check');
                this.$inputMagenta.iCheck('check');
                this.$inputCyan.iCheck('check');
                this.$inputKey.iCheck('check');
            }else{
                this.$inputYellow.iCheck('uncheck');
                this.$inputMagenta.iCheck('uncheck');
                this.$inputCyan.iCheck('uncheck');
                this.$inputKey.iCheck('uncheck');
            }
        },

        changedRetiro: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                this.$inputYellow2.iCheck('check');
                this.$inputMagenta2.iCheck('check');
                this.$inputCyan2.iCheck('check');
                this.$inputKey2.iCheck('check');
            }else{
                this.$inputYellow2.iCheck('uncheck');
                this.$inputMagenta2.iCheck('uncheck');
                this.$inputCyan2.iCheck('uncheck');
                this.$inputKey2.iCheck('uncheck');
            }
        },

        /**
        * Event submit productop
        */
        submitOrdenp2: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                    data.ordenp6 = this.areasProductopList.toJSON();
                this.model.save( data, {silent: true} );
            }
        },

        /**
        * Event submit productop
        */
        submitOrdenp6: function (e) {
            this.$formOrdenp6.submit();
        },

        /**
        * Event Create Folder
        */
        onStoreOrdenp6: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = $.extend({}, window.Misc.formToJson( e.target ), this.parameters.data);
                this.areasProductopList.trigger( 'store' , data );
            }
        },

        /**
        *   Event render input value
        **/
        changeAreap: function(e){
           var _this = this;
               id = this.$(e.currentTarget).val();

           if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '' ){
               $.ajax({
                   url: window.Misc.urlFull( Route.route('areasp.show', {areasp: id}) ),
                   type: 'GET',
                   beforeSend: function() {
                       window.Misc.setSpinner( _this.spinner );
                   }
               })
               .done(function(resp) {
                   window.Misc.removeSpinner( _this.spinner );

                   _this.$inputArea.val('').attr('readonly', true);
                   _this.$inputTiempo.val('');
                   _this.$inputValor.val( resp.areap_valor );
               })
               .fail(function(jqXHR, ajaxOptions, thrownError) {
                   window.Misc.removeSpinner( _this.spinner );
                   alertify.error(thrownError);
               });
           }else{
              this.$inputArea.val('').attr('readonly', false);
              this.$inputTiempo.val('');
              this.$inputValor.val('');
           }
        },

        /**
        *   Event calculate orden2
        **/
        calculateOrdenp2: function () {
            // Igualar variables y quitar el inputmask
            this.cantidad = parseInt( this.$cantidad.val() );
            this.tranporte = Math.round( parseFloat( this.$transporte.inputmask('unmaskedvalue') ) / parseFloat( this.cantidad ) );
            this.viaticos = Math.round( parseFloat( this.$viaticos.inputmask('unmaskedvalue') ) / parseFloat( this.cantidad ) );
            this.areas = Math.round( parseFloat( this.areasProductopList.totalize()['total'] ) / parseFloat( this.cantidad ) );
            this.precio = parseFloat( this.$precio.inputmask('unmaskedvalue') );

            // Cuadros de informacion
            this.$infoprecio.empty().html( window.Misc.currency( this.precio ) );
            this.$infoviaticos.empty().html( window.Misc.currency( this.viaticos ) );
            this.$infotransporte.empty().html( window.Misc.currency( this.tranporte ) );
            this.$infoareas.empty().html( window.Misc.currency( this.areas ) );

            // Calcular total de la orden (transporte+viaticos+precio+areas)
            this.totalOrdenp2 = this.precio + this.tranporte + this.viaticos + this.areas;
            this.$precioOrdenp2.val( this.totalOrdenp2 );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();
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

                // Redirect to orden
                window.Misc.redirect( window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: this.model.get('orden2_orden') })) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class DespachopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DespachopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-despachosp-list',
        events: {
            'click .item-orden-despacho-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            collectionPendientes: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {despachop1_orden: this.parameters.dataFilter.despachop1_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object despachopModel Model instance
        */
        addOne: function (despachopModel) {
            var view = new app.DespachopOrdenItemView({
                model: despachopModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            despachopModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Store despacho
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var despachopModel = new app.DespachopModel();
            despachopModel.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                        // Refresh other collection
                        _this.parameters.collectionPendientes.fetch({ data: {orden2_orden: _this.parameters.dataFilter.despachop1_orden}, reset: true });
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            // Function confirm delete item
            this.confirmDelete( model );


        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { tcontacto_nombre: model.get('tcontacto_nombre'), despachop1_fecha: model.get('despachop1_fecha') },
                    template: _.template( ($('#ordenp-despacho-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar despacho',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);

                                        // Refresh other collection
                                        _this.parameters.collectionPendientes.fetch({ data: {orden2_orden: _this.parameters.dataFilter.despachop1_orden}, reset: true });
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class DespachopOrdenItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DespachopOrdenItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#ordenp-despacho-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class DespachospPendientesOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DespachospPendientesOrdenListView = Backbone.View.extend({

        el: '#browse-orden-despachosp-pendientes-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden2_orden: this.parameters.dataFilter.orden2_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp2Model Model instance
        */
        addOne: function (ordenp2Model) {
            var view = new app.DespachopPendienteOrdenItemView({
                model: ordenp2Model
            });
            ordenp2Model.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        }
   });

})(jQuery, this, this.document);

/**
* Class DespachopPendienteOrdenItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.DespachopPendienteOrdenItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#ordenp-despacho-pendiente-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class EditOrdenpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditOrdenpView = Backbone.View.extend({

        el: '#ordenes-create',
        template: _.template( ($('#add-ordenp-tpl').html() || '') ),
        events: {
            'click .submit-ordenp': 'submitOrdenp',
            'click .close-ordenp': 'closeOrdenp',
            'click .clone-ordenp': 'cloneOrdenp',
            'click .export-ordenp': 'exportOrdenp',
            'change #typeproductop': 'changeTypeProduct',
            'change #subtypeproductop': 'changeSubtypeProduct',
            'submit #form-ordenes': 'onStore',
            'submit #form-despachosp': 'onStoreDespacho'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.productopOrdenList = new app.ProductopOrdenList();
            this.despachopOrdenList = new app.DespachopOrdenList();
            this.despachospPendientesOrdenList = new app.DespachospPendientesOrdenList();
            this.tiempopordenList = new app.TiempopOrdenList();
            this.asientoCuentasList = new app.AsientoCuentasList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.$form = this.$('#form-ordenes');
            this.$product = this.$('#productop');
            this.$subtypeproduct = this.$('#subtypeproductop');
            this.spinner = this.$('#spinner-main');

            // Reference views and ready
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopOrdenListView = new app.ProductopOrdenListView( {
                collection: this.productopOrdenList,
                parameters: {
                    edit: true,
                    iva: this.model.get('orden_iva'),
                    wrapper: this.spinner,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos pendientes list
            this.despachospPendientesOrdenListView = new app.DespachospPendientesOrdenListView( {
                collection: this.despachospPendientesOrdenList,
                parameters: {
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos pendientes list
            this.tiempopordenListView = new app.TiempopOrdenListView( {
                collection: this.tiempopordenList,
                parameters: {
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos list
            this.despachopOrdenListView = new app.DespachopOrdenListView( {
                collection: this.despachopOrdenList,
                parameters: {
                    edit: true,
                    wrapper: this.spinner,
                    collectionPendientes: this.despachospPendientesOrdenList,
                    dataFilter: {
                        despachop1_orden: this.model.get('id')
                    }
               }
            });

            // Detalle asiento list
            this.cuentasListView = new app.AsientoCuentasListView({
                collection: this.asientoCuentasList,
                parameters: {
                    wrapper: this.spinner,
                    edit: false,
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
                }
            });
        },

        /**
        * Event submit productop
        */
        submitOrdenp: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create orden
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event Create despacho
        */
        onStoreDespacho: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.despachop1_orden = this.model.get('id');
                this.despachopOrdenList.trigger( 'store', data );
            }
        },

        /**
        *   Event change select2 type orden
        **/
        changeTypeProduct: function(e) {
            var _this = this,
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).attr('disabled', 'disabled');
                    _this.$subtypeproduct.empty().val(0).removeAttr('disabled');
                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0).attr('disabled', 'disabled');
                this.$product.empty().val(0).attr('disabled', 'disabled');
            }
        },

        /**
        *   Event change select2 subtype orden
        **/
        changeSubtypeProduct: function(e) {
            var _this = this,
                subtypeproduct = this.$(e.currentTarget).val(),
                typeproduct = this.$('#typeproductop').val();

            if( typeof(subtypeproduct) !== 'undefined' && !_.isUndefined(subtypeproduct) && !_.isNull(subtypeproduct) && subtypeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: {
                        subtypeproduct: subtypeproduct,
                        typeproduct: typeproduct
                    },
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$product.empty().val(0).removeAttr('disabled');
                    _this.$product.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$product.append("<option value="+item.id+">"+item.productop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }
        },

        /**
        * export to PDF
        */
        exportOrdenp: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('ordenes.exportar', { ordenes: this.model.get('id') })), '_blank');
        },

        /**
        * Close ordenp
        */
        closeOrdenp: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-close-confirm-tpl').html() || '') ),
                    titleConfirm: 'Cerrar orden de producción',
                    onConfirm: function () {
                        // Close orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.cerrar', { ordenes: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.spinner );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.spinner );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.show', { ordenes: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.spinner );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Clone ordenp
        */
        cloneOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: this.model.get('id') }) ),
                data = { orden_codigo: this.model.get('orden_codigo') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.spinner,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initInputMask();

            if( typeof window.initComponent.initDatePicker == 'function' )
                window.initComponent.initDatePicker();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit orden
                window.Misc.redirect( window.Misc.urlFull( Route.route('ordenes.edit', { ordenes: resp.id}), { trigger:true } ));
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainOrdenesView = Backbone.View.extend({

        el: '#ordenes-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // References
            this.$ordersSearchTable = this.$('#ordenes-search-table');
            this.$searchordenpOrden = this.$('#searchordenp_ordenp_numero');
            this.$searchordenpTercero = this.$('#searchordenp_tercero');
            this.$searchordenpTerceroName = this.$('#searchordenp_tercero_nombre');
            this.$searchordenpEstado = this.$('#searchordenp_ordenp_estado');
            this.$searchordenpReferencia = this.$('#searchordenp_ordenp_referencia');
            this.$searchordenpProductop = this.$('#searchordenp_ordenp_productop');

            this.ordersSearchTable = this.$ordersSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('ordenes.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.orden_numero = _this.$searchordenpOrden.val();
                        data.orden_tercero_nit = _this.$searchordenpTercero.val();
                        data.orden_tercero_nombre = _this.$searchordenpTerceroName.val();
                        data.orden_estado = _this.$searchordenpEstado.val();
                        data.orden_referencia = _this.$searchordenpReferencia.val();
                        data.orden_productop = _this.$searchordenpProductop.val();
                    }
                },
                columns: [
                    { data: 'orden_codigo', name: 'orden_codigo' },
                    { data: 'orden_ano', name: 'orden_ano' },
                    { data: 'orden_numero', name: 'orden_numero' },
                    { data: 'orden_fecha_inicio', name: 'orden_fecha_inicio' },
                    { data: 'orden_fecha_entrega', name: 'orden_fecha_entrega' },
                    { data: 'orden_hora_entrega', name: 'orden_hora_entrega' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' }
                ],
                order: [
                	[ 1, 'desc' ], [ 2, 'desc' ]
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        searchable: false,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('ordenes.show', {ordenes: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [1, 2],
                        visible: false,
                        width: '10%',
                    },
                    {
                        targets: 3,
                        width: '10%',
                    }
                ],
                fnRowCallback: function( row, data ) {
                    if ( parseInt(data.orden_abierta) ) {
                        $(row).css( {"color":"#00a65a"} );
                    }else if ( parseInt(data.orden_anulada) ) {
                        $(row).css( {"color":"red"} );
                    }
                }
			});
        },

        search: function(e) {
            e.preventDefault();

            this.ordersSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchordenpOrden.val('');
            this.$searchordenpTercero.val('');
            this.$searchordenpTerceroName.val('');
            this.$searchordenpEstado.val('');
            this.$searchordenpReferencia.val('');
            this.$searchordenpProductop.val('').trigger('change');

            this.ordersSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class MaquinasProductopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinasProductopListView = Backbone.View.extend({

        el: '#browse-orden-producto-maquinas-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp3Model Model instance
        */
        addOne: function (ordenp3Model) {
            var view = new app.MaquinasProductopItemView({
                model: ordenp3Model
            });
            ordenp3Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class MaquinasProductopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinasProductopItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#orden-producto-maquina-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class MaterialesProductopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopListView = Backbone.View.extend({

        el: '#browse-orden-producto-materiales-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp4Model Model instance
        */
        addOne: function (ordenp4Model) {
            var view = new app.MaterialesProductopItemView({
                model: ordenp4Model
            });
            ordenp4Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            this.ready();

            window.Misc.removeSpinner( this.$el );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },
   });

})(jQuery, this, this.document);

/**
* Class MaterialesProductopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesProductopItemView = Backbone.View.extend({

        tagName: 'div',
        className : 'row',
        template: _.template( ($('#orden-producto-material-item-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        },
    });

})(jQuery, this, this.document);

/**
* Class ProductopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-productop-list',
        events: {
            'click .item-orden-producto-remove': 'removeOne',
            'click .item-orden-producto-clone': 'cloneOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            iva: 0,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$unidades = this.$('#subtotal-cantidad');
            this.$facturado = this.$('#subtotal-facturado');
            this.$subtotal = this.$('#subtotal-total');
            this.$iva = this.$('#iva-total');
            this.$total = this.$('#total-total');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden2_orden: this.parameters.dataFilter.orden2_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object ordenp2Model Model instance
        */
        addOne: function (ordenp2Model) {
            var view = new app.ProductopOrdenItemView({
                model: ordenp2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            ordenp2Model.view = view;
            this.$el.append( view.render().el );

            // Update total
            this.totalize();
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            // function confirm delete item
            this.confirmDelete(model);
        },

        /**
        * modal confirm delete area
        */
        confirmDelete: function( model ) {
            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { producto_nombre: model.get('productop_nombre'), producto_id: model.get('id')},
                    template: _.template( ($('#ordenp-productop-delete-confirm-tpl').html() || '') ),
                    titleConfirm: 'Eliminar producto',
                    onConfirm: function () {
                        if ( model instanceof Backbone.Model ) {
                            model.destroy({
                                success : function(model, resp) {
                                    if(!_.isUndefined(resp.success)) {
                                        window.Misc.removeSpinner( _this.parameters.wrapper );

                                        if( !resp.success ) {
                                            alertify.error(resp.errors);
                                            return;
                                        }

                                        model.view.remove();
                                        _this.collection.remove(model);

                                        // Update total
                                        _this.totalize();
                                    }
                                }
                            });
                        }
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Event clone item
        */
        cloneOne: function (e) {
            e.preventDefault();

            var _this = this,
                resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                route = window.Misc.urlFull( Route.route('ordenes.productos.clonar', { productos: model.get('id') }) ),
                data = { orden2_codigo: model.get('id'), productop_nombre: model.get('productop_nombre') };

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: data,
                    template: _.template( ($('#ordenp-productop-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar producto orden de producción',
                    onConfirm: function () {
                        // Clonar producto
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.parameters.wrapper,
                            'callback': (function(_this){
                                return function(resp){
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.productos.show', { productos: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * Render totalize valores
        */
        totalize: function () {
            var data = this.collection.totalize();

            if(this.$unidades.length) {
                this.$unidades.html( data.unidades );
            }

            if(this.$facturado.length) {
                this.$facturado.html( data.facturado );
            }

            if(this.$subtotal.length) {
                this.$subtotal.html( window.Misc.currency(data.subtotal) );
            }

            var iva = data.subtotal * (this.parameters.iva / 100);
            if(this.$iva.length) {
                this.$iva.html( window.Misc.currency(iva) );
            }

            var total = data.subtotal + iva;
            if(this.$total.length) {
                this.$total.html( window.Misc.currency(total) );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class ProductopOrdenItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProductopOrdenItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#ordenp-producto-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
                attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class ShowOrdenesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowOrdenesView = Backbone.View.extend({

        el: '#ordenes-show',
        events: {
            'click .export-ordenp': 'exportOrdenp',
            'click .open-ordenp': 'openOrdenp',
            'click .clone-ordenp': 'cloneOrdenp'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            this.$iva = this.$('#orden_iva');

            this.productopOrdenList = new app.ProductopOrdenList();
            this.despachopOrdenList = new app.DespachopOrdenList();
            this.tiempopordenList = new app.TiempopOrdenList();

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Productos list
            this.productopOrdenListView = new app.ProductopOrdenListView( {
                collection: this.productopOrdenList,
                parameters: {
                    wrapper: this.$('#wrapper-productop-orden'),
                    iva: this.$iva.val(),
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });

            // Despachos list
            this.despachopOrdenListView = new app.DespachopOrdenListView( {
                collection: this.despachopOrdenList,
                parameters: {
                    wrapper: this.$el,
                    dataFilter: {
                        despachop1_orden: this.model.get('id')
                    }
               }
            });

            // Despachos pendientes list
            this.tiempopordenListView = new app.TiempopOrdenListView( {
                collection: this.tiempopordenList,
                parameters: {
                    dataFilter: {
                        orden2_orden: this.model.get('id')
                    }
               }
            });
        },

        /**
        * Open ordenp
        */
        openOrdenp: function (e) {
            e.preventDefault();

            var _this = this;
            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    dataFilter: { orden_codigo: _this.model.get('orden_codigo') },
                    template: _.template( ($('#ordenp-open-confirm-tpl').html() || '') ),
                    titleConfirm: 'Reabir orden de producción',
                    onConfirm: function () {
                        // Open orden
                        $.ajax({
                            url: window.Misc.urlFull( Route.route('ordenes.abrir', { ordenes: _this.model.get('id') }) ),
                            type: 'GET',
                            beforeSend: function() {
                                window.Misc.setSpinner( _this.el );
                            }
                        })
                        .done(function(resp) {
                            window.Misc.removeSpinner( _this.el );

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

                                window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: _this.model.get('id') })) );
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            window.Misc.removeSpinner( _this.el );
                            alertify.error(thrownError);
                        });
                    }
                }
            });

            cancelConfirm.render();
        },

        /**
        * Clone ordenp
        */
        cloneOrdenp: function (e) {
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: this.model.get('id') }) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#ordenp-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar orden de producción',
                    onConfirm: function () {
                        // Clone orden
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.$el,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('ordenes.edit', { ordenes: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        },

        /**
        * export to PDF
        */
        exportOrdenp: function (e) {
            e.preventDefault();

            // Redirect to pdf
            window.open( window.Misc.urlFull(Route.route('ordenes.exportar', { ordenes: this.model.get('id') })), '_blank');
        }
    });

})(jQuery, this, this.document);

/**
* Class TiempopOrdenListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopOrdenListView = Backbone.View.extend({

        el: '#browse-orden-tiemposp-list',
        events: {
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {orden2_orden: this.parameters.dataFilter.orden2_orden}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopOrdenItemView({
                model: tiempopModel
            });
            tiempopModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        }
   });

})(jQuery, this, this.document);

/**
* Class TiempopOrdenItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopOrdenItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#ordenp-tiempop-item-list-tpl').html() || '') ),
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class MainPermisoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPermisoView = Backbone.View.extend({

        el: '#permisos-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            
            this.$permisosSearchTable = this.$('#permisos-search-table');
            this.$permisosSearchTable.DataTable({
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('permisos.index') ),
                columns: [
                    { data: 'name', name: 'name'},
                    { data: 'display_name', name: 'display_name'},
                    { data: 'description', name: 'description' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%'
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreatePlanCuentaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePlanCuentaView = Backbone.View.extend({

        el: '#plancuentas-create',
        template: _.template( ($('#add-plancuentas-tpl').html() || '') ),
        events: {
            'change input#plancuentas_cuenta': 'cuentaChanged',
            'submit #form-plancuentas': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-plancuentas');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$nivel = this.$('#plancuentas_nivel');

            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

       		if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
		},

        cuentaChanged: function(e) {
            var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('plancuentas.nivel')),
                type: 'GET',
                data: { plancuentas_cuenta: $(e.currentTarget).val() },
                beforeSend: function() {
            		_this.$nivel.val('');
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
           		 	if(_.isUndefined(resp.nivel) || _.isNull(resp.nivel) || !_.isNumber(resp.nivel)) {
		                alertify.error('Ocurrió un error definiendo el nivel de la cuenta, por favor verifique el número de caracteres.');
             		}
                    _this.$nivel.val(resp.nivel);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('plancuentas.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainPlanCuentasView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.MainPlanCuentasView = Backbone.View.extend({

        el: '#plancuentas-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$plancuentasSearchTable = this.$('#plancuentas-search-table');
            this.$searchCuenta = this.$('#plancuentas_cuenta');
            this.$searchName = this.$('#plancuentas_nombre');

            this.plancuentasSearchTable = this.$plancuentasSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('plancuentas.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.plancuentas_cuenta = _this.$searchCuenta.val();
                        data.plancuentas_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentas_cuenta', name: 'plancuentas_cuenta' },
                    { data: 'plancuentas_nivel', name: 'plancuentas_nivel' },
                    { data: 'plancuentas_nombre', name: 'plancuentas_nombre' },
                    { data: 'plancuentas_naturaleza', name: 'plancuentas_naturaleza' },
                    { data: 'plancuentas_tercero', name: 'plancuentas_tercero' },
                    { data: 'plancuentas_equivalente', name: 'plancuentas_equivalente' },
                    { data: 'plancuentas_tipo', name: 'plancuentas_tipo' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '13%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('plancuentas.show', {plancuentas: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '5%'
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return data == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 5,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            if( !_.isNull( full.plancuentas_equivalente ) && !_.isUndefined( full.plancuentas_equivalente ) ){
                                return '<a href="'+ window.Misc.urlFull( Route.route('plancuentasnif.show', {plancuentasnif: full.plancuentas_equivalente }) )  +'">' + full.plancuentasn_cuenta + '</a>';
                            }
                            return '';
                        }
                    },
                    {
                        targets: 6,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            if( data == 'N' ){
                                return 'Ninguno';
                            }else if( data == 'I' ){
                                return 'Inventario';
                            }else if( data == 'C' ){
                                return 'Cartera';
                            }else if( data == 'P' ){
                                return 'Cuentas por pagar';
                            }else{
                                return '';
                            }
                        }
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.plancuentasSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCuenta.val('');
            this.$searchName.val('');

            this.plancuentasSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class CreatePlanCuentaNifView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePlanCuentaNifView = Backbone.View.extend({

        el: '#plancuentasnif-create',
        template: _.template( ($('#add-plancuentasnif-tpl').html() || '') ),
        events: {
            'change input#plancuentasn_cuenta': 'cuentaChanged',
            'submit #form-plancuentasnif': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$wraperForm = this.$('#render-form-plancuentasnif');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.$nivel = this.$('#plancuentasn_nivel');

            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
		},

        cuentaChanged: function(e) {
            var _this = this;

            $.ajax({
                url: window.Misc.urlFull(Route.route('plancuentasnif.nivel')),
                type: 'GET',
                data: { plancuentasn_cuenta: $(e.currentTarget).val() },
                beforeSend: function() {
                    _this.$nivel.val('');
                    window.Misc.setSpinner( _this.el );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.el );
                if(resp.success) {
                    if(_.isUndefined(resp.nivel) || _.isNull(resp.nivel) || !_.isNumber(resp.nivel)) {
                        alertify.error('Ocurrió un error definiendo el nivel de la cuenta, por favor verifique el número de caracteres.');
                    }
                    _this.$nivel.val(resp.nivel);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.el );
                alertify.error(thrownError);
            });
        },

        /**
        * Event Create Cuenta
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
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
                window.Misc.redirect( window.Misc.urlFull( Route.route('plancuentasnif.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainPlanCuentasNifView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});
(function ($, window, document, undefined) {

    app.MainPlanCuentasNifView = Backbone.View.extend({

        el: '#plancuentasnif-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$plancuentasNifSearchTable = this.$('#plancuentasnif-search-table');
            this.$searchCuenta = this.$('#plancuentasn_cuenta');
            this.$searchName = this.$('#plancuentasn_nombre');

            this.plancuentasNifSearchTable = this.$plancuentasNifSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('plancuentasnif.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.plancuentasn_cuenta = _this.$searchCuenta.val();
                        data.plancuentasn_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'plancuentasn_cuenta', name: 'plancuentasn_cuenta' },
                    { data: 'plancuentasn_nivel', name: 'plancuentasn_nivel' },
                    { data: 'plancuentasn_nombre', name: 'plancuentasn_nombre' },
                    { data: 'plancuentasn_naturaleza', name: 'plancuentasn_naturaleza' },
                    { data: 'plancuentasn_tercero', name: 'plancuentasn_tercero' },
                    { data: 'plancuentasn_tipo', name: 'plancuentasn_tipo' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('plancuentasnif.show', { plancuentasnif: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '10%'
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) == 'D' ? 'Débito' : 'Crédito';
                        }
                    },
                    {
                        targets: 4,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                    {
                        targets: 5,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            if( data == 'N' ){
                                return 'Ninguno';
                            }else if( data == 'I' ){
                                return 'Inventario';
                            }else if( data == 'C' ){
                                return 'Cartera';
                            }else if( data == 'P' ){
                                return 'Cuentas por pagar';
                            }else{
                                return '';
                            }
                        }
                    },
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.plancuentasNifSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCuenta.val('');
            this.$searchName.val('');

            this.plancuentasNifSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class CreateProductoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateProductoView = Backbone.View.extend({

        el: '#productos-create',
        template: _.template( ($('#add-producto-tpl').html() || '') ),
        events: {
            'ifChecked #producto_serie': 'serieChange',
            'ifChecked #producto_metrado': 'metradoChange',
            'submit #form-productos': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-producto');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // References
            this.$inputSerie = this.$("#producto_serie");
            this.$inputMetrado = this.$("#producto_metrado");

            this.ready();
        },

        serieChange: function (e) {

            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputMetrado.iCheck('uncheck');
            }
        },

        metradoChange: function (e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$inputSerie.iCheck('uncheck');
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

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

                window.Misc.redirect( window.Misc.urlFull( Route.route('productos.show', { productos: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainProductosView = Backbone.View.extend({

        el: '#productos-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$productosSearchTable = this.$('#productos-search-table');
            this.$searchCod = this.$('#producto_codigo');
            this.$searchName = this.$('#producto_nombre');

            this.productosSearchTable = this.$productosSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productos.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.producto_codigo = _this.$searchCod.val();
                        data.producto_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'producto_codigo', name: 'producto_codigo' },
                    { data: 'producto_nombre', name: 'producto_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo producto',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('productos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('productos.show', {productos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.productosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCod.val('');
            this.$searchName.val('');

            this.productosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class ShowProductosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductoView = Backbone.View.extend({

        el: '#producto-show',
        templateItemsRollo: _.template( ($('#itemrollo-product-tpl').html() || '') ),
        events: {
            'click .get-info-availability': 'getInfoAvailability'
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            // Referencie fields
            this.$('#browse-prodbode-table').hide();
            this.sucursal = null;
            this.call = null;

            // Collection
            this.itemRolloINList = new app.ItemRolloINList();
            this.prodbodeList = new app.ProdBodeList();
        },

        /**
        * Event show series products father's OR
        * Event show metros in rollos
        */
        getInfoAvailability: function(e){
            e.preventDefault();

            if (this.$(e.target).attr('data-action') === 'rollos') {

                // sucursal
                this.sucursal = this.$(e.target).attr('data-sucursal');

                // Modale open
                this.$modalGeneric = $('#modal-product-generic');
                this.$modalGeneric.modal('show');
                this.$modalGeneric.find('.content-modal').empty().html(this.templateItemsRollo( ) );
                this.$modalGeneric.find('.modal-title').text( 'Productos metrados' );

            }else if (this.$(e.target).attr('data-action') === 'series'){
                this.call = true;
                this.$('#browse-prodbode-table').show();
            }
            this.referenceViews();

        },

        /**
        * Reference to views
        */
        referenceViews: function () {
            // Detalle prodBode list
            this.prodbodeListView = new app.ProdbodeListView({
                collection: this.prodbodeList,
                parameters: {
                    dataFilter: {
                        'producto_id': this.model.get('id'),
                        'call': this.call
                    }
                }
            });

            // Detalle item rollo list
            this.itemRolloListView = new app.ItemRolloListView({
                collection: this.itemRolloINList,
                parameters: {
                    choose: false,
                    show: true,
                    dataFilter: {
                        'producto_id': this.model.get('id'),
                        'sucursal': this.sucursal,
                    }
                }
            });
        }
    });
})(jQuery, this, this.document);

/**
* Class AcabadoItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadoItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#productop-acabado-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class AcabadosListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AcabadosListView = Backbone.View.extend({

        el: '#browse-acabados-productop-list',
        events: {
            'click .item-productop6-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.parameters.wrapper

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {productop_id: this.parameters.dataFilter.productop_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object productop6Model Model instance
        */
        addOne: function (productop6Model) {
            var view = new app.AcabadoItemView({
                model: productop6Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            productop6Model.view = view;
            this.$el.prepend( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.productop6_productop = this.parameters.dataFilter.productop_id;

            // Add model in collection
            var productop6Model = new app.Productop6Model();
            productop6Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });

            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-productosp6') );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class AreaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreaItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#productop-area-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class AreasListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AreasListView = Backbone.View.extend({

        el: '#browse-areas-productop-list',
        events: {
            'click .item-productop3-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.parameters.wrapper

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {productop_id: this.parameters.dataFilter.productop_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object productop3Model Model instance
        */
        addOne: function (productop3Model) {
            var view = new app.AreaItemView({
                model: productop3Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            productop3Model.view = view;
            this.$el.prepend( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.productop3_productop = this.parameters.dataFilter.productop_id;

            // Add model in collection
            var productop3Model = new app.Productop3Model();
            productop3Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });

            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-productosp3') );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class CreateProductopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateProductopView = Backbone.View.extend({

        el: '#productosp-create',
        template: _.template( ($('#add-productop-tpl').html() || '') ),
        events: {
            'ifChanged .change-productop-abierto-koi-component': 'changedAbierto',
            'ifChanged .change-productop-cerrado-koi-component': 'changedCerrado',
            'ifChanged .change-productop-3d-koi-component': 'changed3d',
            'change #productop_tipoproductop': 'changeTypeProduct',
            'click .submit-productosp': 'submitProductop',
            'submit #form-productosp': 'onStore',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
                attributes.edit = false;

            this.$el.html( this.template(attributes) );

            this.$inputAbierto = $('#productop_abierto');
            this.$inputAbiertoAncho = $('#productop_ancho_med');
            this.$inputAbiertoAlto = $('#productop_alto_med');

            this.$inputCerrado = $('#productop_cerrado');
            this.$inputCerradoAncho = $('#productop_c_med_ancho');
            this.$inputCerradoAlto = $('#productop_c_med_alto');

            this.$input3d = $('#productop_3d');
            this.$input3dAncho = $('#productop_3d_ancho_med');
            this.$input3dAlto = $('#productop_3d_alto_med');
            this.$input3dProfundidad = $('#productop_3d_profundidad_med');

            this.$form = this.$('#form-productosp');
            this.$subtypeproduct = this.$('#productop_subtipoproductop');
            this.spinner = this.$('#spinner-main');

            this.ready();
        },

        /**
        * Event submit productop
        */
        submitProductop: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        changedAbierto: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            }else{
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changedCerrado: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            }else{
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changed3d: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                // Abierto
                this.$inputAbierto.iCheck('uncheck');
                this.$inputAbierto.iCheck('disable');
                this.$inputAbiertoAncho.prop('disabled', true).val('');
                this.$inputAbiertoAlto.prop('disabled', true).val('');

                // Cerrado
                this.$inputCerrado.iCheck('uncheck');
                this.$inputCerrado.iCheck('disable');
                this.$inputCerradoAncho.prop('disabled', true).val('');
                this.$inputCerradoAlto.prop('disabled', true).val('');
            }else{
                // Abierto
                this.$inputAbierto.iCheck('enable');
                this.$inputAbiertoAncho.prop('disabled', false);
                this.$inputAbiertoAlto.prop('disabled', false);

                // Cerrado
                this.$inputCerrado.iCheck('enable');
                this.$inputCerradoAncho.prop('disabled', false);
                this.$inputCerradoAlto.prop('disabled', false);
            }
        },

        changeTypeProduct: function(e) {
            var _this = this;
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$subtypeproduct.empty().val(0);

                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0);
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // ProductopView undelegateEvents
                if ( this.createProductopView instanceof Backbone.View ){
                    this.createProductopView.stopListening();
                    this.createProductopView.undelegateEvents();
                }

                // Redirect to edit orden
                Backbone.history.navigate( Route.route('productosp.edit', { productosp: resp.id}), { trigger:true } );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class EditProductopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditProductopView = Backbone.View.extend({

        el: '#productosp-create',
        template: _.template( ($('#add-productop-tpl').html() || '') ),
        events: {
            'ifChanged .change-productop-abierto-koi-component': 'changedAbierto',
            'ifChanged .change-productop-cerrado-koi-component': 'changedCerrado',
            'ifChanged .change-productop-3d-koi-component': 'changed3d',
            'change #productop_tipoproductop': 'changeTypeProduct',
            'click .submit-productosp': 'submitProductop',
            'submit #form-productosp': 'onStore',
            'submit #form-productosp2': 'onStoreTip',
            'submit #form-productosp3': 'onStoreArea',
            'submit #form-productosp4': 'onStoreMaquina',
            'submit #form-productosp5': 'onStoreMaterial',
            'submit #form-productosp6': 'onStoreAcabado'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.tipsList = new app.TipsList();
            this.areasList = new app.AreasList();
            this.maquinasList = new app.MaquinasList();
            this.materialesList = new app.MaterialesList();
            this.acabadosList = new app.AcabadosList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;

            this.$el.html( this.template(attributes) );
            this.$form = this.$('#form-productosp');
            this.spinner = this.$('#spinner-main');

            this.$inputAbierto = $('#productop_abierto');
            this.$inputAbiertoAncho = $('#productop_ancho_med');
            this.$inputAbiertoAlto = $('#productop_alto_med');

            this.$inputCerrado = $('#productop_cerrado');
            this.$inputCerradoAncho = $('#productop_c_med_ancho');
            this.$inputCerradoAlto = $('#productop_c_med_alto');

            this.$input3d = $('#productop_3d');
            this.$input3dAncho = $('#productop_3d_ancho_med');
            this.$input3dAlto = $('#productop_3d_alto_med');
            this.$input3dProfundidad = $('#productop_3d_profundidad_med');

            this.$subtypeproduct = this.$('#productop_subtipoproductop');

            // Reference views && ready
            this.referenceViews();
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Tips list
            this.tipsListView = new app.TipsListView( {
                collection: this.tipsList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-tips'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.areasListView = new app.AreasListView( {
                collection: this.areasList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-areas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.maquinasListView = new app.MaquinasListView( {
                collection: this.maquinasList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-maquinas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Materiales list
            this.materialesListView = new app.MaterialesListView( {
                collection: this.materialesList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-materiales'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Acabados list
            this.acabadosListView = new app.AcabadosListView( {
                collection: this.acabadosList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-productop-acabados'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event submit productop
        */
        submitProductop: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        changedAbierto: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            }else{
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changedCerrado: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$input3d.iCheck('uncheck');
                this.$input3d.iCheck('disable');
                this.$input3dAncho.prop('disabled', true).val('');
                this.$input3dAlto.prop('disabled', true).val('');
                this.$input3dProfundidad.prop('disabled', true).val('');
            }else{
                this.$input3d.iCheck('enable');
                this.$input3dAncho.prop('disabled', false);
                this.$input3dAlto.prop('disabled', false);
                this.$input3dProfundidad.prop('disabled', false);
            }
        },

        changed3d: function(e) {

            var selected = $(e.target).is(':checked');
            if( selected ){
                // Abierto
                this.$inputAbierto.iCheck('uncheck');
                this.$inputAbierto.iCheck('disable');
                this.$inputAbiertoAncho.prop('disabled', true).val('');
                this.$inputAbiertoAlto.prop('disabled', true).val('');

                // Cerrado
                this.$inputCerrado.iCheck('uncheck');
                this.$inputCerrado.iCheck('disable');
                this.$inputCerradoAncho.prop('disabled', true).val('');
                this.$inputCerradoAlto.prop('disabled', true).val('');
            }else{
                // Abierto
                this.$inputAbierto.iCheck('enable');
                this.$inputAbiertoAncho.prop('disabled', false);
                this.$inputAbiertoAlto.prop('disabled', false);

                // Cerrado
                this.$inputCerrado.iCheck('enable');
                this.$inputCerradoAncho.prop('disabled', false);
                this.$inputCerradoAlto.prop('disabled', false);
            }
        },

        changeTypeProduct: function(e) {
            var _this = this;
                typeproduct = this.$(e.currentTarget).val();

            if( typeof(typeproduct) !== 'undefined' && !_.isUndefined(typeproduct) && !_.isNull(typeproduct) && typeproduct != '' ){
                $.ajax({
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index', {typeproduct: typeproduct}) ),
                    type: 'GET',
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinner );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinner );

                    _this.$subtypeproduct.empty().val(0);

                    _this.$subtypeproduct.append("<option value=></option>");
                    _.each(resp, function(item){
                        _this.$subtypeproduct.append("<option value="+item.id+">"+item.subtipoproductop_nombre+"</option>");
                    });

                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinner );
                    alertify.error(thrownError);
                });
            }else{
                this.$subtypeproduct.empty().val(0);
            }
        },

        /**
        * Event Create Tip
        */
        onStoreTip: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.tipsList.trigger( 'store', data );
            }
        },

        /**
        * Event Create area
        */
        onStoreArea: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.areasList.trigger( 'store', data );
            }
        },

        /**
        * Event Create maquina
        */
        onStoreMaquina: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.maquinasList.trigger( 'store', data );
            }
        },

        /**
        * Event Create material
        */
        onStoreMaterial: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.materialesList.trigger( 'store', data );
            }
        },

        /**
        * Event Create acabado
        */
        onStoreAcabado: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.acabadosList.trigger( 'store', data );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit productop
                window.Misc.redirect( window.Misc.urlFull( Route.route('productosp.show', { productosp: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainProductospView = Backbone.View.extend({

        el: '#productosp-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$productospSearchTable = this.$('#productosp-search-table');
            this.$searchCod = this.$('#productop_codigo');
            this.$searchName = this.$('#productop_nombre');

            this.productospSearchTable = this.$productospSearchTable.DataTable({
                dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('productosp.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.datatables = true;
                        data.productop_codigo = _this.$searchCod.val();
                        data.productop_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'productop_codigo', name: 'productop_codigo' },
                    { data: 'productop_nombre', name: 'productop_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo producto',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('productosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('productosp.show', {productosp: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.productospSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchCod.val('');
            this.$searchName.val('');

            this.productospSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class MaquinaItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinaItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#productop-maquina-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class MaquinasListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaquinasListView = Backbone.View.extend({

        el: '#browse-maquinas-productop-list',
        events: {
            'click .item-productop4-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.parameters.wrapper

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {productop_id: this.parameters.dataFilter.productop_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object productop4Model Model instance
        */
        addOne: function (productop4Model) {
            var view = new app.MaquinaItemView({
                model: productop4Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            productop4Model.view = view;
            this.$el.prepend( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.productop4_productop = this.parameters.dataFilter.productop_id;

            // Add model in collection
            var productop4Model = new app.Productop4Model();
            productop4Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });

            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-productosp4') );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class MaterialesListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialesListView = Backbone.View.extend({

        el: '#browse-materiales-productop-list',
        events: {
            'click .item-productop5-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.parameters.wrapper

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {productop_id: this.parameters.dataFilter.productop_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object productop5Model Model instance
        */
        addOne: function (productop5Model) {
            var view = new app.MaterialItemView({
                model: productop5Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            productop5Model.view = view;
            this.$el.prepend( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.productop5_productop = this.parameters.dataFilter.productop_id;

            // Add model in collection
            var productop5Model = new app.Productop5Model();
            productop5Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });

            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-productosp5') );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class MaterialItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MaterialItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#productop-material-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class ShowProductopView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowProductopView = Backbone.View.extend({

        el: '#productop-show',
        events: {
            'click .clone-productop': 'cloneProductop',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.tipsList = new app.TipsList();
                this.areasList = new app.AreasList();
                this.maquinasList = new app.MaquinasList();
                this.materialesList = new app.MaterialesList();
                this.acabadosList = new app.AcabadosList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
       		// Tips list
            this.tipsListView = new app.TipsListView( {
                collection: this.tipsList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-tips'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.areasListView = new app.AreasListView( {
                collection: this.areasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-areas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Areas list
            this.maquinasListView = new app.MaquinasListView( {
                collection: this.maquinasList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-maquinas'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Materiales list
            this.materialesListView = new app.MaterialesListView( {
                collection: this.materialesList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-materiales'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });

            // Acabados list
            this.acabadosListView = new app.AcabadosListView( {
                collection: this.acabadosList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-productop-acabados'),
                    dataFilter: {
                        'productop_id': this.model.get('id')
                    }
               }
            });
        },

        cloneProductop: function(e){
            e.preventDefault();

            var _this = this,
                route = window.Misc.urlFull( Route.route('productosp.clonar', { productosp: this.model.get('id')}) );

            var cloneConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#productop-clone-confirm-tpl').html() || '') ),
                    titleConfirm: 'Clonar producto',
                    onConfirm: function () {
                        // Clone producto
                        window.Misc.cloneModule({
                            'url': route,
                            'wrap': _this.el,
                            'callback': (function (_this) {
                                return function ( resp )
                                {
                                    window.Misc.successRedirect( resp.msg, window.Misc.urlFull(Route.route('productosp.show', { productosp: resp.id })) );
                                }
                            })(_this)
                        });
                    }
                }
            });

            cloneConfirm.render();
        }
    });

})(jQuery, this, this.document);

/**
* Class TipItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TipItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#productop-tip-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;

            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class TipsListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TipsListView = Backbone.View.extend({

        el: '#browse-tips-productop-list',
        events: {
            'click .item-productop2-remove': 'removeOne'
        },
        parameters: {
        	wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.parameters.wrapper

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {productop_id: this.parameters.dataFilter.productop_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object productop2Model Model instance
        */
        addOne: function (productop2Model) {
            var view = new app.TipItemView({
                model: productop2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            productop2Model.view = view;
            this.$el.prepend( view.render().el );

        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.productop2_productop = this.parameters.dataFilter.productop_id;

            // Add model in collection
            var productop2Model = new app.Productop2Model();
            productop2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });

            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );

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

                window.Misc.clearForm( $('#form-productosp2') );
            }
        }
   });

})(jQuery, this, this.document);

/**
* Class CreatePuntoventaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePuntoventaView = Backbone.View.extend({

        el: '#puntosventa-create',
        template: _.template( ($('#add-puntoventa-tpl').html() || '') ),
        events: {
            'submit #form-puntosventa': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-puntosventa');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('puntosventa.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainPuntoventaView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainPuntoventaView = Backbone.View.extend({

        el: '#puntosventa-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$puntosventaSearchTable = this.$('#puntosventa-search-table');

            this.$puntosventaSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('puntosventa.index') ),
                columns: [
                    { data: 'puntoventa_nombre', name: 'puntoventa_nombre' },
                    { data: 'puntoventa_prefijo', name: 'puntoventa_prefijo' },
                    { data: 'puntoventa_resolucion_dian', name: 'puntoventa_resolucion_dian' },
                    { data: 'puntoventa_numero', name: 'puntoventa_numero' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo punto de venta',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('puntosventa.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('puntosventa.show', {puntosventa: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateRolView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateRolView = Backbone.View.extend({

        el: '#rol-create',
        template: _.template( ($('#add-rol-tpl').html() || '') ),
        events: {
            'submit #form-roles': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            // Events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = false;
            this.$el.html( this.template(attributes) );

            this.spinner = this.$('#spinner-main');
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit rol
                Backbone.history.navigate(Route.route('roles.edit', { roles: resp.id}), { trigger: true });
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class CreatePermisoRolView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreatePermisoRolView = Backbone.View.extend({

        el: '#modal-permisorol-component',
        template: _.template( ($('#edit-permissions-tpl').html() || '') ),
        events: {
            'submit #form-permisorol-component': 'onStore'
        },
        parameters: {
        	permissions : [],
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.$el.find('.inner-title-modal').empty().html( this.model.get('display_name') );
            this.$wraperContent = this.$el.find('.modal-body');

            // Events
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function(){
            // Attributes
            var attributes = this.model.toJSON();
            attributes.permissions = this.parameters.permissions;

            this.$el.find('.content-modal').empty().html( this.template( attributes ) );

            // to fire plugins
            this.ready();

            this.$el.modal('show');

            return this;
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();
        },

        /**
        * Event Create Contact
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.role_id = this.parameters.dataFilter.role_id;

                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

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

                this.collection.fetch({ data: this.parameters.dataFilter, reset: true });

            	this.$el.modal('hide');
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class EditRolView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EditRolView = Backbone.View.extend({

        el: '#rol-create',
        template: _.template( ($('#add-rol-tpl').html() || '') ),
        events: {
            'submit #form-roles': 'onStore',
            'click .toggle-children': 'toggleChildren',
            'click .btn-set-permission': 'changePermissions'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.stuffToDo = { };
            this.stuffToVw = { };

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
                attributes.edit = true;
            this.$el.html( this.template(attributes) );

            this.spinner = this.$('#spinner-main');
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event toggle children
        */
        toggleChildren: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                father = $(e.currentTarget).attr("data-father"),
                nivel1 = $(e.currentTarget).attr("data-nivel1"),
                nivel2 = $(e.currentTarget).attr("data-nivel2"),
                _this = this;

            if ( (this.stuffToVw[resource] instanceof Backbone.View) == false )
            {
                this.stuffToDo[resource] = new app.PermisosRolList();
                this.stuffToVw[resource] = new app.PermisosRolListView({
                    el: '#wrapper-permisions-'+resource,
                    collection: this.stuffToDo[resource],
                    parameters: {
                        wrapper: this.$('#wrapper-father-'+father),
                        permissions: this.model.get('permissions'),
                        father: resource,
                        dataFilter: {
                            'role_id': this.model.get('id'),
                            'nivel1': nivel1,
                            'nivel2': nivel2
                        }
                   }
                });
            }

        },

        changePermissions: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                father = $(e.currentTarget).attr("data-father"),
                collection = this.stuffToDo[father],
                model = collection.get(resource),
                _this = this;

            if ( this.createPermisoRolView instanceof Backbone.View ){
                this.createPermisoRolView.stopListening();
                this.createPermisoRolView.undelegateEvents();
            }

            this.createPermisoRolView = new app.CreatePermisoRolView({
                model: model,
                collection: collection,
                parameters: {
                    permissions: this.model.get('permissions'),
                    dataFilter: {
                        'role_id': this.model.get('id'),
                        'nivel1': model.get('nivel1'),
                        'nivel2': model.get('nivel2')
                    }
                }
            });
            this.createPermisoRolView.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.spinner );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.spinner );

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

                // Redirect to edit rol
                window.Misc.redirect( window.Misc.urlFull( Route.route('roles.edit', { roles: resp.id}) ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainRolesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainRolesView = Backbone.View.extend({

        el: '#roles-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$rolesSearchTable = this.$('#roles-search-table');
            this.$rolesSearchTable.DataTable({
                dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('roles.index') ),
                columns: [
                    { data: 'display_name', name: 'display_name' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Nuevo Rol',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.Misc.redirect( window.Misc.urlFull( Route.route('roles.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '25%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('roles.show', {roles: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class PermisosRolItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PermisosRolItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#permissions-rol-list-tpl').html() || '') ),
        parameters: {
            father: null,
            permissions: [],
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;
            attributes.father = this.parameters.father;
            attributes.permissions = this.parameters.permissions;

            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class PermisosRolListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PermisosRolListView = Backbone.View.extend({

        events: {

        },
        parameters: {
            wrapper: null,
            father: null,
            edit: false,
            permissions: [],
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: this.parameters.dataFilter, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view rol by model
        * @param Object contactModel Model instance
        */
        addOne: function (moduloModel) {
            var view = new app.PermisosRolItemView({
                model: moduloModel,
                parameters: {
                    father: this.parameters.father,
                    permissions: this.parameters.permissions,
                    edit: this.parameters.edit
                }
            });
            moduloModel.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class CreateSubActividadpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSubActividadpView = Backbone.View.extend({

        el: '#subactividadp-create',
        template: _.template( ($('#add-subactividadp-tpl').html() || '') ),
        events: {
            'submit #form-subactividadp': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-subactividadp');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initSpinner == 'function' )
                window.initComponent.initSpinner();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('subactividadesp.index')) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainSubActividadespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubActividadespView = Backbone.View.extend({

        el: '#subactividadesp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$subactividadespSearchTable = this.$('#subactividadesp-search-table');

            this.$subactividadespSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('subactividadesp.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'actividadp_nombre', name: 'actividadp_nombre'},
                    { data: 'subactividadp_nombre', name: 'subactividadp_nombre'},
                    { data: 'subactividadp_activo', name: 'subactividadp_activo' }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-user-plus"></i> Nueva Subactividad',
                        className: 'btn-sm',
                        action: function ( e, dt, node, config ) {
                                window.Misc.redirect( window.Misc.urlFull( Route.route('subactividadesp.create') ) )
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('subactividadesp.show', {subactividadesp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 3,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateSubGrupoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSubGrupoView = Backbone.View.extend({

        el: '#subgrupos-create',
        template: _.template( ($('#add-subgrupo-tpl').html() || '') ),
        events: {
            'submit #form-subgrupos': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-subgrupo');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('subgrupos.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainSubGruposView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubGruposView = Backbone.View.extend({

        el: '#subgrupos-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$subgruposSearchTable = this.$('#subgrupos-search-table');

            this.$subgruposSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('subgrupos.index') ),
                columns: [
                    { data: 'subgrupo_codigo', name: 'subgrupo_codigo' },
                    { data: 'subgrupo_nombre', name: 'subgrupo_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo subgrupo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('subgrupos.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('subgrupos.show', {subgrupos: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateSubtipoProductopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSubtipoProductopView = Backbone.View.extend({

        el: '#subtipoproductop-create',
        template: _.template( ($('#add-subtipoproductop-tpl').html() || '') ),
        events: {
            'submit #form-subtipoproductop': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-subtipoproductop');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();

            if( typeof window.initComponent.initSelect2 == 'function' )
                window.initComponent.initSelect2();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('subtipoproductosp.index' )) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainSubtipoProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSubtipoProductospView = Backbone.View.extend({

        el: '#subtipoproductosp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$subtipoproductospSearchTable = this.$('#subtipoproductosp-search-table');

            this.$subtipoproductospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('subtipoproductosp.index') ),
                    data: function( data ) {
                        data.datatables = true;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subtipoproductop_nombre', name: 'subtipoproductop_nombre' },
                    { data: 'tipoproductop_nombre', name: 'tipoproductop_nombre' },
                    { data: 'subtipoproductop_activo', name: 'subtipoproductop_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo Subtipo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('subtipoproductosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('subtipoproductosp.show', {subtipoproductosp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [3],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateSucursalView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateSucursalView = Backbone.View.extend({

        el: '#sucursales-create',
        template: _.template( ($('#add-sucursal-tpl').html() || '') ),
        events: {
            'submit #form-sucursales': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-sucursal');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('sucursales.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainSucursalesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSucursalesView = Backbone.View.extend({

        el: '#sucursales-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$sucursalesSearchTable = this.$('#sucursales-search-table');

            this.$sucursalesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('sucursales.index') ),
                columns: [
                    { data: 'sucursal_nombre', name: 'sucursal_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nueva sucursal',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('sucursales.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('sucursales.show', {sucursales: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class ContactItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ContactItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#contact-item-list-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class ContactsListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ContactsListView = Backbone.View.extend({

        el: '#browse-contact-list',
        events: {
            'click .btn-edit-tcontacto': 'editOne',
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            // Trigger
            this.on('createOne', this.createOne, this);

            this.collection.fetch({ data: {tercero_id: this.parameters.dataFilter.tercero_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view contact by model
        * @param Object contactModel Model instance
        */
        addOne: function (contactModel) {
            var view = new app.ContactItemView( { model: contactModel } );
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },


        editOne: function(e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( this.createTContactoView instanceof Backbone.View ){
                this.createTContactoView.stopListening();
                this.createTContactoView.undelegateEvents();
            }

            this.createTContactoView = new app.CreateTContactoView({
                model: model
            });
            this.createTContactoView.render();
        },

        createOne: function(tercero, address, nomenclatura, municipio) {
            var _this = this;

            if ( this.createTContactoView instanceof Backbone.View ){
                this.createTContactoView.stopListening();
                this.createTContactoView.undelegateEvents();
            }

            this.createTContactoView = new app.CreateTContactoView({
                model: new app.ContactoModel({
                    tcontacto_direccion: address,
                    tcontacto_direccion_nomenclatura: nomenclatura,
                    tcontacto_municipio: municipio
                }),
                collection: _this.collection,
                parameters: {
                    'tercero_id': tercero
               }
            });
            this.createTContactoView.render();
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);

/**
* Class CreateTerceroView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTerceroView = Backbone.View.extend({

        el: '#tercero-create',
        template: _.template( ($('#add-tercero-tpl').html() || '') ),
        events: {
            'submit #form-tercero': 'onStore',
            'submit #form-item-roles': 'onStoreRol',
            'submit #form-changed-password': 'onStorePassword',
            'ifChanged .change_employee': 'changedEmployee',
            'ifChanged #tercero_tecnico': 'changedTechnical',
            'ifChanged #tercero_coordinador': 'changedCoordinador',
            'click .btn-add-tcontacto': 'addContacto'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.msgSuccess = 'Tercero guardado con exito!';
            this.$wraperForm = this.$('#render-form-tercero');

            // Model exist
            if( this.model.id != undefined ) {
                this.contactsList = new app.ContactsList();
                this.rolList = new app.RolList();
            }

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

            this.$form = this.$('#form-tercero');
            this.$formAccounting = this.$('#form-accounting');
            this.$formEmployee = this.$('#form-employee');

            this.$checkEmployee = this.$('#tercero_empleado');
            this.$checkInternal = this.$('#tercero_interno');

            this.$coordinador_por = this.$('#tercero_coordinador_por');

            this.$username = this.$('#username');
            this.$password = this.$('#password');
            this.$password_confirmation = this.$('#password_confirmation');

            this.$wrapperEmployes = this.$('#wrapper-empleados');
            this.$wrapperCoordinador = this.$('#wrapper-coordinador');

            // Model exist
            if( this.model.id != undefined ) {

                // Reference views
                this.referenceViews();
            }
            this.ready();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-tcontacto'),
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });
            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: true,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });
        },

        /**
        * Event Create Forum Post
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = $.extend({}, window.Misc.formToJson( e.target ), window.Misc.formToJson( this.$formAccounting ), window.Misc.formToJson( this.$formEmployee ));
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item rol
        */
        onStoreRol: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                // Prepare global data
                var data = window.Misc.formToJson( e.target );
                this.rolList.trigger( 'store', data );
            }
        },

        addContacto: function() {
            this.contactsListView.trigger('createOne',
                this.model.get('id'),
                this.model.get('tercero_direccion'),
                this.model.get('tercero_dir_nomenclatura'),
                this.model.get('tercero_municipio')
            );
        },

        changedTechnical: function(e) {
            var selected = $(e.target).is(':checked');
            if( selected ) {
                this.$wrapperCoordinador.removeClass('hide');
            }else{
                this.$wrapperCoordinador.addClass('hide');
            }
        },

        changedCoordinador: function(e){
            var selected = $(e.target).is(':checked');
            var nombre = this.model.get('tercero_nombre1')+' '+this.model.get('tercero_nombre2')+' '+this.model.get('tercero_apellido1')+' '+this.model.get('tercero_apellido2');
            var select = [{id: this.model.get('id') , text: nombre}];

            if( selected ) {
                this.$coordinador_por.select2({ data: select }).trigger('change');
                this.$coordinador_por.select2({ language: 'es', placeholder: 'Seleccione', allowClear: false });
            }else{
                this.$coordinador_por.find('option[value='+this.model.get('id')+']').remove();
            }
        },

        changedEmployee: function(e) {
            // Active if internal or employee
            if( this.$checkInternal.is(':checked') || this.$checkEmployee.is(':checked') ) {
                this.$wrapperEmployes.removeClass('hide')
            }else{
                this.$wrapperEmployes.addClass('hide')
            }
        },

        onStorePassword: function(e) {
            var _this = this;

            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                data.id = this.model.get('id');

                $.ajax({
                    type: "POST",
                    url: window.Misc.urlFull( Route.route('terceros.setpassword') ),
                    data: data,
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.$('#wrapper-password') );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.el );
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

                        alertify.success(resp.message);
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.$('#wrapper-password') );
                    alertify.error(thrownError);
                });
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

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                alertify.success(this.msgSuccess);

                // CreateTerceroView undelegateEvents
                if ( this.createTerceroView instanceof Backbone.View ){
                    this.createTerceroView.stopListening();
                    this.createTerceroView.undelegateEvents();
                }

                // Redirect to edit tercero
                Backbone.history.navigate(Route.route('terceros.edit', { terceros: resp.id}), { trigger:true });
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateTContactoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTContactoView = Backbone.View.extend({

        el: 'body',
        template: _.template( ($('#add-contacto-tpl').html() || '') ),
        events: {
            'submit #form-tcontacto-component': 'onStore'
        },
        parameters: {
        	tercero_id : null
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events
            this.listenTo( this.model, 'change:id', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );

            this.$modalComponent = this.$('#modal-tcontacto-component');
        },

        /*
        * Render View Element
        */
        render: function(){
            // Attributes
            var attributes = this.model.toJSON();

            this.$modalComponent.find('.content-modal').html('').html( this.template( attributes ) );
            this.$wraperContent = this.$('#content-tcontacto-component').find('.modal-body');

            // to fire plugins
            this.ready();

            this.$modalComponent.modal('show');

            return this;
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
        },

        /**
        * Event Create Contact
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {

                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
				if( !_.isUndefined(this.parameters.tercero_id) && !_.isNull(this.parameters.tercero_id) && this.parameters.tercero_id != '') {
                	data.tcontacto_tercero = this.parameters.tercero_id;
                }
                this.model.save( data, {patch: true} );
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.$wraperContent );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.$wraperContent );

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

                if(this.collection instanceof Backbone.Collection) {
	                // Add model in collection
	            	this.collection.add(model);
	            }

            	this.$modalComponent.modal('hide');
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class FacturaptListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.FacturaptListView = Backbone.View.extend({

        el: '#browse-facturap-list',
        events: {
            //
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {tercero_id: this.parameters.dataFilter.tercero_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function(){

        },

        /**
        * Render view contact by model
        * @param Object Facturap2Model Model instance
        */
        addOne: function (Facturap2Model) {
            var view = new app.FacturaptItemView( { model: Facturap2Model } );
            this.$el.append( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.el );
        }
   });

})(jQuery, this, this.document);

/**
* Class FacturaptItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.FacturaptItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#facturapt-item-list-tpl').html() || '') ),
        events: {

        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }

    });

})(jQuery, this, this.document);
/**
* Class MainTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTerceroView = Backbone.View.extend({

        el: '#terceros-main',
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear'
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;

            // Rerefences
            this.$tercerosSearchTable = this.$('#terceros-search-table');
            this.$searchNit = this.$('#tercero_nit');
            this.$searchName = this.$('#tercero_nombre');

            this.tercerosSearchTable = this.$tercerosSearchTable.DataTable({
				dom: "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: {
                    url: window.Misc.urlFull( Route.route('terceros.index') ),
                    data: function( data ) {
                        data.persistent = true;
                        data.tercero_nit = _this.$searchNit.val();
                        data.tercero_nombre = _this.$searchName.val();
                    }
                },
                columns: [
                    { data: 'tercero_nit', name: 'tercero_nit' },
                    { data: 'tercero_nombre', name: 'tercero_nombre' },
                    { data: 'tercero_razonsocial', name: 'tercero_razonsocial'},
                    { data: 'tercero_nombre1', name: 'tercero_nombre1' },
                    { data: 'tercero_nombre2', name: 'tercero_nombre2' },
                    { data: 'tercero_apellido1', name: 'tercero_apellido1' },
                    { data: 'tercero_apellido2', name: 'tercero_apellido2' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '15%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('terceros.show', {terceros: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: 1,
                        width: '85%',
                        searchable: false
                    },
                    {
                        targets: [2, 3, 4, 5, 6],
                        visible: false
                    }
                ]
			});
        },

        search: function(e) {
            e.preventDefault();

            this.tercerosSearchTable.ajax.reload();
        },

        clear: function(e) {
            e.preventDefault();

            this.$searchNit.val('');
            this.$searchName.val('');

            this.tercerosSearchTable.ajax.reload();
        },
    });

})(jQuery, this, this.document);

/**
* Class RolesListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RolesListView = Backbone.View.extend({

        el: '#browse-roles-list',
        events: {
            'click .item-roles-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch({ data: {tercero_id: this.parameters.dataFilter.tercero_id}, reset: true });
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        * Render view rol by model
        * @param Object contactModel Model instance
        */
        addOne: function (usuariorolModel) {
            var view = new app.RolItemView({
                model: usuariorolModel,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            usuariorolModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storesrol
        * @param form element
        */
        storeOne: function (data) {
            var _this = this
            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Prepare data
            data.user_id = this.parameters.dataFilter.tercero_id;

            // Add model in collection
            var usuariorolModel = new app.UsuarioRolModel();
            usuariorolModel.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

                /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource"),
                model = this.collection.get(resource),
                _this = this;

            if ( model instanceof Backbone.Model ) {
                model.destroy({
                    data: { user_id: this.parameters.dataFilter.tercero_id },
                    processData: true,
                    success : function(model, resp) {
                        if(!_.isUndefined(resp.success)) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );

                            if( !resp.success ) {
                                alertify.error(resp.errors);
                                return;
                            }

                            model.view.remove();
                        }
                    }
                });
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class RolItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.RolItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#roles-item-list-tpl').html() || '') ),
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class ShowTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTerceroView = Backbone.View.extend({

        el: '#terceros-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.contactsList = new app.ContactsList();
                this.facturaptList = new app.FacturaptList();
                this.rolList = new app.RolList();
                this.detalleFacturaList = new app.DetalleFactura4List();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Rol list
            this.rolesListView = new app.RolesListView( {
                collection: this.rolList,
                parameters: {
                    edit: false,
                    wrapper: this.$('#wrapper-roles'),
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Facturap list
            this.facturaptListView = new app.FacturaptListView( {
                collection: this.facturaptList,
                parameters: {
                    dataFilter: {
                        tercero_id: this.model.get('id')
                    }
               }
            });

            // Detalle list
            this.factura4ListView = new app.Factura4ListView({
                collection: this.detalleFacturaList,
                parameters: {
                    edit: false,
                    template: _.template( ($('#add-detalle-factura-cartera-tpl').html() || '') ),
                    call: 'tercero',
                    dataFilter: {
                        tercero_id: this.model.get('id'),
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class TiempopActionView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopActionView = Backbone.View.extend({

        el: '#tiempop-content-section',
        template: _.template(($('#edit-tiempop-tpl').html() || '')),
        events: {
            'click .submit-edit-tiempop': 'submitForm',
            'submit #form-edit-tiempop': 'onStore',
        },
        parameters: {
            action: {}
        },

        /**
        * Constructor Method
        */
        initialize : function( opts ) {
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            this.$modal = $('#modal-edit-tiempop');
            this.$form =  this.$('#form-edit-tiempop');
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.parameters.model;
            this.$modal.find('.modal-title').text( 'Tiempo de producción - Editar # '+ attributes.id );
            this.$modal.find('.content-modal').empty().html( this.template( attributes ) );

            this.ready();
		},

        /**
        * Sumbit form
        */
        submitForm: function(e){
            this.$form.submit();
        },

        /**
        *   Event store
        */
        onStore: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var _this = this,
                    data = window.Misc.formToJson( e.target );

                var model = _.find( this.parameters.collection.models, function(item) {
                    return item.get('id') == _this.parameters.model.id;
                });

                if(model instanceof Backbone.Model ) {
                    model.save( data ,{
                        success : function(model, resp) {
                            if(!_.isUndefined(resp.success)) {
                                window.Misc.removeSpinner( _this.parameters.wrapper );

                                var text = resp.success ? '' : resp.errors;
                                if( _.isObject( resp.errors ) ) {
                                    text = window.Misc.parseErrors(resp.errors);
                                }

                                if( !resp.success ) {
                                    alertify.error(text);
                                    return;
                                }

                                alertify.success( resp.msg );
                                _this.parameters.collection.fetch();
                                _this.$modal.modal('hide');
                            }
                        },
                        error : function(model, error) {
                            window.Misc.removeSpinner( _this.parameters.wrapper );
                            alertify.error(error.statusText)
                        }
                    });
                }
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

            if( typeof window.initComponent.initTimePicker == 'function' )
                window.initComponent.initTimePicker();
        },
    });

})(jQuery, this, this.document);

/**
* Class TiempopItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#tiempop-item-list-tpl').html() || '') ),
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
	        // Extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );
            return this;
        }
    });

})(jQuery, this, this.document);

/**
* Class TiempopListView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TiempopListView = Backbone.View.extend({

        el: '#browse-tiemposp-list',
        events: {
            'click .edit-tiempop': 'editTiempop',
        },
        parameters: {
        	wrapper: null,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            this.$modal = $('#modal-edit-tiempop');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);

            this.collection.fetch();
        },

        /*
        * Render View Element
        */
        render: function() {

        },

        /**
        *  Edit tiempo de produccion
        **/
        editTiempop: function(e){
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                var tiempo = {
                    id: this.$(e.currentTarget).data('tiempo-resource'),
                    fecha: this.$(e.currentTarget).data('tiempo-fecha'),
                    horai: this.$(e.currentTarget).data('tiempo-hi'),
                    horaf: this.$(e.currentTarget).data('tiempo-hf')
                };

                this.$modal.modal('show');

                // Open tiempopActionView
                if ( this.tiempopActionView instanceof Backbone.View ){
                    this.tiempopActionView.stopListening();
                    this.tiempopActionView.undelegateEvents();
                }

                this.tiempopActionView = new app.TiempopActionView({
                    parameters: {
                        collection: this.collection,
                        model: tiempo
                    }
                });

                this.tiempopActionView.render();
            }
        },

        /**
        * Render view contact by model
        * @param Object tiempopModel Model instance
        */
        addOne: function (tiempopModel) {
            var view = new app.TiempopItemView({
                model: tiempopModel
            });
            tiempopModel.view = view;
            this.$el.prepend( view.render().el );
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {
            this.$el.find('tbody').html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * store
        * @param form element
        */
        storeOne: function ( data ) {
            var _this = this;

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );
            //
            // Add model in collection
            var tiempopModel = new app.TiempopModel();
            tiempopModel.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
                        window.Misc.removeSpinner( _this.parameters.wrapper );

                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                        window.Misc.clearForm( $('#form-tiempop') );
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {
            window.Misc.removeSpinner( this.$el );
        }
   });

})(jQuery, this, this.document);

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

/**
* Class CreateTipoMaterialpView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTipoMaterialpView = Backbone.View.extend({

        el: '#tipomaterialesp-create',
        template: _.template( ($('#add-tipomaterialp-tpl').html() || '') ),
        events: {
            'submit #form-tipomaterialp': 'onStore'
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-tipomaterialp');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('tipomaterialesp.index' )) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainTipoMaterialespView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoMaterialespView = Backbone.View.extend({

        el: '#tipomaterialesp-main',
        
        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tipomaterialpSearchTablese = this.$('#tipomaterialesp-search-table');

            this.$tipomaterialpSearchTablese.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tipomaterialesp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipomaterialp_nombre', name: 'tipomaterialp_nombre' },
                    { data: 'tipomaterialp_activo', name: 'tipomaterialp_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nueva tipo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tipomaterialesp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tipomaterialesp.show', {tipomaterialesp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateTipoProductopView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTipoProductopView = Backbone.View.extend({

        el: '#tipoproductop-create',
        template: _.template( ($('#add-tipoproductop-tpl').html() || '') ),
        events: {
            'submit #form-tipoproductop': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-tipoproductop');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initICheck == 'function' )
                window.initComponent.initICheck();

            if( typeof window.initComponent.initValidator == 'function' )
                window.initComponent.initValidator();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('tipoproductosp.index' )) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainTipoProductospView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTipoProductospView = Backbone.View.extend({

        el: '#tipoproductosp-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$tipoproductospSearchTable = this.$('#tipoproductosp-search-table');

            this.$tipoproductospSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('tipoproductosp.index') ),
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'tipoproductop_nombre', name: 'tipoproductop_nombre' },
                    { data: 'tipoproductop_activo', name: 'tipoproductop_activo' },
                ],
				buttons: [
					{
						text: '<i class="fa fa-plus"></i> Nuevo tipo',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('tipoproductosp.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('tipoproductosp.show', {tipoproductosp: full.id }) )  +'">' + data + '</a>';
                        }
                    },
                    {
                        targets: [2],
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return parseInt(data) ? 'Si' : 'No';
                        }
                    },
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class CreateTrasladoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateTrasladoView = Backbone.View.extend({

        el: '#traslados-create',
        template: _.template( ($('#add-traslado-tpl').html() || '') ),
        events: {
            'click .submit-traslado': 'submitTraslado',
            'submit #form-item-traslado': 'onStoreItem',
            'submit #form-traslado': 'onStore',
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-traslado');

            this.trasladoProductosList = new app.TrasladoProductosList();

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            // References
            this.$form = this.$('#form-traslado');
            this.$formItem = this.$('#form-item-traslado');

            // Reference views
            this.referenceViews();
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Detalle traslado list
            this.productosListView = new app.TrasladoProductosListView({
                collection: this.trasladoProductosList,
                parameters: {
                    wrapper: this.el,
                    edit: true
                }
            });
        },

        /**
        * Event submit traslado
        */
        submitTraslado: function (e) {
            this.$form.submit();
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                data.detalle = this.trasladoProductosList.toJSON()
                console.log(data);
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /**
        * Event add item detalle traslado
        */
        onStoreItem: function (e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                var data = data = window.Misc.formToJson( e.target );
                    data.tipo = 'S';
                    data.sucursal = this.$('#traslado1_sucursal').val();
                    data.destino = this.$('#traslado1_destino').val();

                    window.Misc.evaluateActionsInventory({
                        'data': data,
                        'wrap': this.$el,
                        'callback': (function (_this) {
                            return function ( action, tipo, producto )
                            {
                                // Open InventarioActionView
                                if ( _this.inventarioActionView instanceof Backbone.View ){
                                    _this.inventarioActionView.stopListening();
                                    _this.inventarioActionView.undelegateEvents();
                                }
                                _this.inventarioActionView = new app.InventarioActionView({
                                    model: _this.model,
                                    collection: _this.trasladoProductosList,
                                    parameters: {
                                        data: data,
                                        action: action,
                                        tipo: tipo,
                                        producto: producto,
                                        form:_this.$formItem
                                    }
                                });
                                _this.inventarioActionView.render();
                            }
                        })(this)
                    });
                // this.trasladoProductosList.trigger( 'store', data );
            }
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('traslados.show', { traslados: resp.id})) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainTrasladosView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainTrasladosView = Backbone.View.extend({

        el: '#traslados-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$trasladosSearchTable = this.$('#traslados-search-table');

            this.$trasladosSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('traslados.index') ),
                columns: [
                    { data: 'traslado1_numero', name: 'traslado1_numero' },
                    { data: 'sucursa_origen', name: 'sucursa_origen' },
                    { data: 'sucursa_destino', name: 'sucursa_destino' },
                    { data: 'traslado1_fecha', name: 'traslado1_fecha' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo traslado',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('traslados.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('traslados.show', {traslados: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
* Class ShowTrasladoView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTrasladoView = Backbone.View.extend({

        el: '#traslados-show',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

            	this.trasladoProductosList = new app.TrasladoProductosList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
    		// Detalle traslado list
            this.productosListView = new app.TrasladoProductosListView({
                collection: this.trasladoProductosList,
                parameters: {
                    wrapper: this.el,
                    edit: false,
                    dataFilter: {
                    	traslado: this.model.get('id')
                    }
                }
            });
        }
    });

})(jQuery, this, this.document);

/**
* Class TrasladoProductosListView of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TrasladoProductosListView = Backbone.View.extend({

        el: '#browse-detalle-traslado-list',
        events: {
            'click .item-traslado2-remove': 'removeOne'
        },
        parameters: {
            wrapper: null,
            edit: false,
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // References
            this.$costoTotal = this.$('#total-costo');

            // Init Attributes
            this.confCollection = { reset: true, data: {} };

            // // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'sync', this.responseServer );

            /* if was passed traslado code */
            if( !_.isUndefined(this.parameters.dataFilter.traslado) && !_.isNull(this.parameters.dataFilter.traslado) ){
                 this.confCollection.data.traslado = this.parameters.dataFilter.traslado;

                this.collection.fetch( this.confCollection );
            }
        },

        /**
        * Render view task by model
        * @param Object mentoringTaskModel Model instance
        */
        addOne: function (Traslado2Model) {
            var view = new app.TrasladoProductosItemView({
                model: Traslado2Model,
                parameters: {
                    edit: this.parameters.edit
                }
            });
            Traslado2Model.view = view;
            this.$el.append( view.render().el );
        },

        /**
        * Render all view tast of the collection
        */
        addAll: function () {
            this.collection.forEach( this.addOne, this );
        },

        /**
        * storescuenta
        * @param form element
        */
        storeOne: function (data) {
            var _this = this

            // Set Spinner
            window.Misc.setSpinner( this.parameters.wrapper );

            // Add model in collection
            var traslado2Model = new app.Traslado2Model();
            traslado2Model.save(data, {
                success : function(model, resp) {
                    if(!_.isUndefined(resp.success)) {
						window.Misc.removeSpinner( _this.parameters.wrapper );

                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }

                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Add model in collection
                        _this.collection.add(model);
                    }
                },
                error : function(model, error) {
                    window.Misc.removeSpinner( _this.parameters.wrapper );
                    alertify.error(error.statusText)
                }
            });
        },

        /**
        * Event remove item
        */
        removeOne: function (e) {
            e.preventDefault();

            var resource = $(e.currentTarget).attr("data-resource");
            var model = this.collection.get(resource);
            if ( model instanceof Backbone.Model ) {
                model.view.remove();
                this.collection.remove(model);
            }
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (model, xhr, opts) {
            window.Misc.setSpinner( this.parameters.wrapper );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner( this.parameters.wrapper );
        }
   });

})(jQuery, this, this.document);

/**
* Class TrasladoProductosItemView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.TrasladoProductosItemView = Backbone.View.extend({

        tagName: 'tr',
        template: _.template( ($('#add-traslado2-item-tpl').html() || '') ),
        events: {
        },
        parameters: {
            edit: false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){
            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            attributes.edit = this.parameters.edit;
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
/**
* Class CreateUnidadView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CreateUnidadView = Backbone.View.extend({

        el: '#unidades-create',
        template: _.template( ($('#add-unidad-tpl').html() || '') ),
        events: {
            'submit #form-unidades': 'onStore'
        },
        parameters: {
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Attributes
            this.$wraperForm = this.$('#render-form-unidad');

            // Events
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'request', this.loadSpinner );
        },

        /**
        * Event Create Folder
        */
        onStore: function (e) {

            if (!e.isDefaultPrevented()) {

                e.preventDefault();
                var data = window.Misc.formToJson( e.target );
                this.model.save( data, {patch: true, silent: true} );
            }
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$wraperForm.html( this.template(attributes) );

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();
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

                window.Misc.redirect( window.Misc.urlFull( Route.route('unidades.index') ) );
            }
        }
    });

})(jQuery, this, this.document);

/**
* Class MainUnidadesView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainUnidadesView = Backbone.View.extend({

        el: '#unidades-main',

        /**
        * Constructor Method
        */
        initialize : function() {

            this.$unidadesSearchTable = this.$('#unidades-search-table');

            this.$unidadesSearchTable.DataTable({
				dom: "<'row'<'col-sm-4'B><'col-sm-4 text-center'l><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				processing: true,
                serverSide: true,
            	language: window.Misc.dataTableES(),
                ajax: window.Misc.urlFull( Route.route('unidades.index') ),
                columns: [
                    { data: 'unidadmedida_sigla', name: 'unidadmedida_sigla' },
                    { data: 'unidadmedida_nombre', name: 'unidadmedida_nombre' }
                ],
				buttons: [
					{
						text: '<i class="fa fa-user-plus"></i> Nuevo unidad',
                        className: 'btn-sm',
						action: function ( e, dt, node, config ) {
							window.Misc.redirect( window.Misc.urlFull( Route.route('unidades.create') ) )
						}
					}
				],
                columnDefs: [
                    {
                        targets: 0,
                        width: '10%',
                        render: function ( data, type, full, row ) {
                            return '<a href="'+ window.Misc.urlFull( Route.route('unidades.show', {unidades: full.id }) )  +'">' + data + '</a>';
                        }
                    }
                ]
			});
        }
    });

})(jQuery, this, this.document);

/**
 * Utilities for seg component
 *
 *
 */
( function( $, window, document, undefined ){

    var Misc = function( a ){

        // attributes or global vars here

    }

    Misc.prototype = {

        /**
        * Inializes the functions when DOM ready
        */
        initialize: function(){

        },

        /**
         *  Serialize form into json format
         *
         *  @param { string } name class or id of the html element to embed the loader
         *  @return { object } form into json
         *
         */
        formToJson: function( selector ){
            var o = {}, a = [];
            if( $.prototype.isPrototypeOf(selector) ){
                a = selector.serializeArray();
            }
            else{
                a = $(selector).serializeArray();
            }

            $.each( a, function() {
                if ( o[ this.name ] !== undefined ) {
                    if ( ! o[this.name].push ) {
                        o[ this.name ] = [ o[ this.name ] ];
                    }

                    o[ this.name ].push( this.value || '' );

                } else {
                    o[ this.name ] = this.value || '';
                }
            });

            return o;
        },

        /**
        * validate the urls
        */
        isUrl : function( str ){

            // var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+\.[a-zA-Z]{2,3}(\/([^\n\r\s])*)?(\?([^\n\r\s])*)?/i;
            var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+(\/(.)*)?(\?(.)*)?/i;

            return patt.test( str );
        },

        /**
        * Build URI with route and base url
        */
        urlFull: function ( route ){

            if( !this.isUrl(document.url) )
                return route;

            route || (route = '');
            var patt = /^\//;
            patt.test(route) || (route = '/'+route);

            return document.url + route;
        },

        /**
        * Build URI with route and base url
        */
        parseErrors: function ( errors ){
            var text = '';
            if( _.isObject( errors ) ){

                var listError = '<ul>';

                $.each(errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
            return text;
        },

        /**
        *  Sets a loading spinner in a box
        * @param { selector } String|Object Selector jQuery
        */
        setSpinner: function( selector ){
            if ( !selector ) return;

            $(selector).prepend('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        },

        /**
        * Removes the loading spinner and trigger a callback
        * @param { wrap } String|Object wrapper jQuery element
        *
        */
        removeSpinner: function( selector ){

            var $selector = $(selector).find( '.overlay' );

            if($selector.length)
                $selector.remove();
        },

        /**
        *   ClearFields the forms
        */
        clearForm: function( form ){

            form.trigger('reset');

            form.find(':input').each(function(){
                field_type = $(this);

                // Inputmask data-currency
                if ( field_type.attr('data-currency') == '' || field_type.attr('data-currency-negative') == ''){
                    field_type.val('');
                }

                if( field_type.hasClass('timepicker') ){
                    field_type.val( moment().format('H:mm') );
                }

                // Checkbox && radiobutton
                if( field_type.attr('type') == 'radio' || field_type.attr('type') == 'checkbox'){
                    field_type.iCheck('update');
                }

                // Select2
                if( field_type.hasClass('select2-default-clear') || field_type.hasClass('select2-default') ){
                    var name = field_type.attr('id');
                    field_type.val('').trigger('change');
                    $('#select2-'+name+'-container').removeAttr('title');

                    // Select2 with ajax
                }else if( field_type.hasClass('choice-select-autocomplete') ){
                    field_type.empty();
                    id = field_type.attr('id');
                    $('#select2-'+id+'-container').removeAttr('title');
                }
            });
        },

        /**
        * Display the DataTables interface in Spanish
        */
        dataTableES: function(){
            return {
                "sProcessing":     "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        },

        /**
        * Redirect to an specific url or refresh the page
        * @param { string } the url to be redirect to
        *
        */
        redirect: function( url ){
            if( url !== undefined && url != ''){
                window.location = url;
            }else{
                window.location.reload();
            }
        },

        /**
        * Redirect to an specific url or refresh the page
        * @param { string } the url to be redirect to
        *
        */
        successRedirect: function( msg, url ){
            alertify.success(msg);
            setTimeout(function(){
                window.Misc.redirect( url );
            }, 500);
        },

        /**
        * Format COP currency
        * @param { value }
        *
        */
        currency: function( value ){
            return accounting.formatMoney(value, '', 2, ".", ",");
        },

        /**
        * Evaluate actions accounts
        */
        evaluateActionsAccount: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Search plancuenta
            $.ajax({
                url: window.Misc.urlFull(Route.route('asientos.detalle.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.actions );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },
        /**
        * Evaluate actions accounts
        */
        evaluateActionsAccountNif: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Search plancuenta
            $.ajax({
                url: window.Misc.urlFull(Route.route('asientosnif.detalle.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.actions );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Evaluate facturap
        */
        evaluateFacturap: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'facturap': null,
                'tercero': null,
                'naturaleza': null
            }, settings = {};
            settings = $.extend({}, defaults, options);

            // Search facturap
            $.ajax({
                url: window.Misc.urlFull(Route.route('facturap.search')),
                type: 'GET',
                data: { facturap1_factura: settings.facturap, tercero_nit: settings.tercero },
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );
                var response = { actions: false };

                if(resp.success) {
                    // Evaluate actions
                    response.actions = true;
                    response.facturap = resp.id;
                    response.action = 'quota';

                }else{
                    if(settings.naturaleza == 'C') {
                        response.actions = true;
                        response.action = 'add';

                    }else if(settings.naturaleza == 'D') {
                        response.message = 'Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.';
                    }
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( response );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },
        /**
        *Evaluate action Inventory
        */
        evaluateActionsInventory: function(options){
            options || (options = {});
            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);
            $.ajax({
                url: window.Misc.urlFull(Route.route('productos.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.action, resp.tipo, resp.producto );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Clone module
        */
        cloneModule: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'url': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Clone module
            $.ajax({
                url: settings.url,
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },
    };

    window.Misc = new Misc();
    window.Misc.initialize();

})( jQuery, this, this.document );

(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["POST"],"uri":"auth\/login","name":"auth.login","action":"App\Http\Controllers\Auth\AuthController@postLogin"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/logout","name":"auth.logout","action":"App\Http\Controllers\Auth\AuthController@getLogout"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/integrate","name":"auth.integrate","action":"App\Http\Controllers\Auth\AuthController@integrate"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Auth\AuthController@getLogin"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"dashboard","action":"App\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/dv","name":"terceros.dv","action":"App\Http\Controllers\Admin\TerceroController@dv"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/rcree","name":"terceros.rcree","action":"App\Http\Controllers\Admin\TerceroController@rcree"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/search","name":"terceros.search","action":"App\Http\Controllers\Admin\TerceroController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/facturap","name":"terceros.facturap","action":"App\Http\Controllers\Admin\TerceroController@facturap"},{"host":null,"methods":["POST"],"uri":"terceros\/setpassword","name":"terceros.setpassword","action":"App\Http\Controllers\Admin\TerceroController@setpassword"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/contactos","name":"terceros.contactos.index","action":"App\Http\Controllers\Admin\ContactoController@index"},{"host":null,"methods":["POST"],"uri":"terceros\/contactos","name":"terceros.contactos.store","action":"App\Http\Controllers\Admin\ContactoController@store"},{"host":null,"methods":["PUT"],"uri":"terceros\/contactos\/{contactos}","name":"terceros.contactos.update","action":"App\Http\Controllers\Admin\ContactoController@update"},{"host":null,"methods":["PATCH"],"uri":"terceros\/contactos\/{contactos}","name":null,"action":"App\Http\Controllers\Admin\ContactoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/roles","name":"terceros.roles.index","action":"App\Http\Controllers\Admin\UsuarioRolController@index"},{"host":null,"methods":["POST"],"uri":"terceros\/roles","name":"terceros.roles.store","action":"App\Http\Controllers\Admin\UsuarioRolController@store"},{"host":null,"methods":["DELETE"],"uri":"terceros\/roles\/{roles}","name":"terceros.roles.destroy","action":"App\Http\Controllers\Admin\UsuarioRolController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros","name":"terceros.index","action":"App\Http\Controllers\Admin\TerceroController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/create","name":"terceros.create","action":"App\Http\Controllers\Admin\TerceroController@create"},{"host":null,"methods":["POST"],"uri":"terceros","name":"terceros.store","action":"App\Http\Controllers\Admin\TerceroController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/{terceros}","name":"terceros.show","action":"App\Http\Controllers\Admin\TerceroController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"terceros\/{terceros}\/edit","name":"terceros.edit","action":"App\Http\Controllers\Admin\TerceroController@edit"},{"host":null,"methods":["PUT"],"uri":"terceros\/{terceros}","name":"terceros.update","action":"App\Http\Controllers\Admin\TerceroController@update"},{"host":null,"methods":["PATCH"],"uri":"terceros\/{terceros}","name":null,"action":"App\Http\Controllers\Admin\TerceroController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"empresa","name":"empresa.index","action":"App\Http\Controllers\Admin\EmpresaController@index"},{"host":null,"methods":["PUT"],"uri":"empresa\/{empresa}","name":"empresa.update","action":"App\Http\Controllers\Admin\EmpresaController@update"},{"host":null,"methods":["PATCH"],"uri":"empresa\/{empresa}","name":null,"action":"App\Http\Controllers\Admin\EmpresaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"municipios","name":"municipios.index","action":"App\Http\Controllers\Admin\MunicipioController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"actividades","name":"actividades.index","action":"App\Http\Controllers\Admin\ActividadController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"actividades\/create","name":"actividades.create","action":"App\Http\Controllers\Admin\ActividadController@create"},{"host":null,"methods":["POST"],"uri":"actividades","name":"actividades.store","action":"App\Http\Controllers\Admin\ActividadController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"actividades\/{actividades}","name":"actividades.show","action":"App\Http\Controllers\Admin\ActividadController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"actividades\/{actividades}\/edit","name":"actividades.edit","action":"App\Http\Controllers\Admin\ActividadController@edit"},{"host":null,"methods":["PUT"],"uri":"actividades\/{actividades}","name":"actividades.update","action":"App\Http\Controllers\Admin\ActividadController@update"},{"host":null,"methods":["PATCH"],"uri":"actividades\/{actividades}","name":null,"action":"App\Http\Controllers\Admin\ActividadController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"departamentos","name":"departamentos.index","action":"App\Http\Controllers\Admin\DepartamentoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"departamentos\/{departamentos}","name":"departamentos.show","action":"App\Http\Controllers\Admin\DepartamentoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"sucursales","name":"sucursales.index","action":"App\Http\Controllers\Admin\SucursalController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"sucursales\/create","name":"sucursales.create","action":"App\Http\Controllers\Admin\SucursalController@create"},{"host":null,"methods":["POST"],"uri":"sucursales","name":"sucursales.store","action":"App\Http\Controllers\Admin\SucursalController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"sucursales\/{sucursales}","name":"sucursales.show","action":"App\Http\Controllers\Admin\SucursalController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"sucursales\/{sucursales}\/edit","name":"sucursales.edit","action":"App\Http\Controllers\Admin\SucursalController@edit"},{"host":null,"methods":["PUT"],"uri":"sucursales\/{sucursales}","name":"sucursales.update","action":"App\Http\Controllers\Admin\SucursalController@update"},{"host":null,"methods":["PATCH"],"uri":"sucursales\/{sucursales}","name":null,"action":"App\Http\Controllers\Admin\SucursalController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"puntosventa","name":"puntosventa.index","action":"App\Http\Controllers\Admin\PuntoVentaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"puntosventa\/create","name":"puntosventa.create","action":"App\Http\Controllers\Admin\PuntoVentaController@create"},{"host":null,"methods":["POST"],"uri":"puntosventa","name":"puntosventa.store","action":"App\Http\Controllers\Admin\PuntoVentaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"puntosventa\/{puntosventa}","name":"puntosventa.show","action":"App\Http\Controllers\Admin\PuntoVentaController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"puntosventa\/{puntosventa}\/edit","name":"puntosventa.edit","action":"App\Http\Controllers\Admin\PuntoVentaController@edit"},{"host":null,"methods":["PUT"],"uri":"puntosventa\/{puntosventa}","name":"puntosventa.update","action":"App\Http\Controllers\Admin\PuntoVentaController@update"},{"host":null,"methods":["PATCH"],"uri":"puntosventa\/{puntosventa}","name":null,"action":"App\Http\Controllers\Admin\PuntoVentaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"roles\/permisos","name":"roles.permisos.index","action":"App\Http\Controllers\Admin\PermisoRolController@index"},{"host":null,"methods":["PUT"],"uri":"roles\/permisos\/{permisos}","name":"roles.permisos.update","action":"App\Http\Controllers\Admin\PermisoRolController@update"},{"host":null,"methods":["PATCH"],"uri":"roles\/permisos\/{permisos}","name":null,"action":"App\Http\Controllers\Admin\PermisoRolController@update"},{"host":null,"methods":["DELETE"],"uri":"roles\/permisos\/{permisos}","name":"roles.permisos.destroy","action":"App\Http\Controllers\Admin\PermisoRolController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"roles","name":"roles.index","action":"App\Http\Controllers\Admin\RolController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"roles\/create","name":"roles.create","action":"App\Http\Controllers\Admin\RolController@create"},{"host":null,"methods":["POST"],"uri":"roles","name":"roles.store","action":"App\Http\Controllers\Admin\RolController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"roles\/{roles}","name":"roles.show","action":"App\Http\Controllers\Admin\RolController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"roles\/{roles}\/edit","name":"roles.edit","action":"App\Http\Controllers\Admin\RolController@edit"},{"host":null,"methods":["PUT"],"uri":"roles\/{roles}","name":"roles.update","action":"App\Http\Controllers\Admin\RolController@update"},{"host":null,"methods":["PATCH"],"uri":"roles\/{roles}","name":null,"action":"App\Http\Controllers\Admin\RolController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"permisos","name":"permisos.index","action":"App\Http\Controllers\Admin\PermisoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"modulos","name":"modulos.index","action":"App\Http\Controllers\Admin\ModuloController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas\/nivel","name":"plancuentas.nivel","action":"App\Http\Controllers\Accounting\PlanCuentasController@nivel"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas\/search","name":"plancuentas.search","action":"App\Http\Controllers\Accounting\PlanCuentasController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas","name":"plancuentas.index","action":"App\Http\Controllers\Accounting\PlanCuentasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas\/create","name":"plancuentas.create","action":"App\Http\Controllers\Accounting\PlanCuentasController@create"},{"host":null,"methods":["POST"],"uri":"plancuentas","name":"plancuentas.store","action":"App\Http\Controllers\Accounting\PlanCuentasController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas\/{plancuentas}","name":"plancuentas.show","action":"App\Http\Controllers\Accounting\PlanCuentasController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentas\/{plancuentas}\/edit","name":"plancuentas.edit","action":"App\Http\Controllers\Accounting\PlanCuentasController@edit"},{"host":null,"methods":["PUT"],"uri":"plancuentas\/{plancuentas}","name":"plancuentas.update","action":"App\Http\Controllers\Accounting\PlanCuentasController@update"},{"host":null,"methods":["PATCH"],"uri":"plancuentas\/{plancuentas}","name":null,"action":"App\Http\Controllers\Accounting\PlanCuentasController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif\/nivel","name":"plancuentasnif.nivel","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@nivel"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif\/search","name":"plancuentasnif.search","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif","name":"plancuentasnif.index","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif\/create","name":"plancuentasnif.create","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@create"},{"host":null,"methods":["POST"],"uri":"plancuentasnif","name":"plancuentasnif.store","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif\/{plancuentasnif}","name":"plancuentasnif.show","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"plancuentasnif\/{plancuentasnif}\/edit","name":"plancuentasnif.edit","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@edit"},{"host":null,"methods":["PUT"],"uri":"plancuentasnif\/{plancuentasnif}","name":"plancuentasnif.update","action":"App\Http\Controllers\Accounting\PlanCuentasNifController@update"},{"host":null,"methods":["PATCH"],"uri":"plancuentasnif\/{plancuentasnif}","name":null,"action":"App\Http\Controllers\Accounting\PlanCuentasNifController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"documentos\/filter","name":"documentos.filter","action":"App\Http\Controllers\Accounting\DocumentoController@filter"},{"host":null,"methods":["GET","HEAD"],"uri":"documentos","name":"documentos.index","action":"App\Http\Controllers\Accounting\DocumentoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"documentos\/create","name":"documentos.create","action":"App\Http\Controllers\Accounting\DocumentoController@create"},{"host":null,"methods":["POST"],"uri":"documentos","name":"documentos.store","action":"App\Http\Controllers\Accounting\DocumentoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"documentos\/{documentos}","name":"documentos.show","action":"App\Http\Controllers\Accounting\DocumentoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"documentos\/{documentos}\/edit","name":"documentos.edit","action":"App\Http\Controllers\Accounting\DocumentoController@edit"},{"host":null,"methods":["PUT"],"uri":"documentos\/{documentos}","name":"documentos.update","action":"App\Http\Controllers\Accounting\DocumentoController@update"},{"host":null,"methods":["PATCH"],"uri":"documentos\/{documentos}","name":null,"action":"App\Http\Controllers\Accounting\DocumentoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/detalle","name":"asientos.detalle.index","action":"App\Http\Controllers\Accounting\DetalleAsientoController@index"},{"host":null,"methods":["POST"],"uri":"asientos\/detalle","name":"asientos.detalle.store","action":"App\Http\Controllers\Accounting\DetalleAsientoController@store"},{"host":null,"methods":["DELETE"],"uri":"asientos\/detalle\/{detalle}","name":"asientos.detalle.destroy","action":"App\Http\Controllers\Accounting\DetalleAsientoController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/exportar\/{asientos}","name":"asientos.exportar","action":"App\Http\Controllers\Accounting\AsientoController@exportar"},{"host":null,"methods":["POST"],"uri":"asientos\/detalle\/evaluate","name":"asientos.detalle.evaluate","action":"App\Http\Controllers\Accounting\DetalleAsientoController@evaluate"},{"host":null,"methods":["POST"],"uri":"asientos\/detalle\/validate","name":"asientos.detalle.validate","action":"App\Http\Controllers\Accounting\DetalleAsientoController@validation"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/detalle\/movimientos","name":"asientos.detalle.movimientos","action":"App\Http\Controllers\Accounting\DetalleAsientoController@movimientos"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos","name":"asientos.index","action":"App\Http\Controllers\Accounting\AsientoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/create","name":"asientos.create","action":"App\Http\Controllers\Accounting\AsientoController@create"},{"host":null,"methods":["POST"],"uri":"asientos","name":"asientos.store","action":"App\Http\Controllers\Accounting\AsientoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/{asientos}","name":"asientos.show","action":"App\Http\Controllers\Accounting\AsientoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"asientos\/{asientos}\/edit","name":"asientos.edit","action":"App\Http\Controllers\Accounting\AsientoController@edit"},{"host":null,"methods":["PUT"],"uri":"asientos\/{asientos}","name":"asientos.update","action":"App\Http\Controllers\Accounting\AsientoController@update"},{"host":null,"methods":["PATCH"],"uri":"asientos\/{asientos}","name":null,"action":"App\Http\Controllers\Accounting\AsientoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif\/detalle","name":"asientosnif.detalle.index","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@index"},{"host":null,"methods":["POST"],"uri":"asientosnif\/detalle","name":"asientosnif.detalle.store","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@store"},{"host":null,"methods":["DELETE"],"uri":"asientosnif\/detalle\/{detalle}","name":"asientosnif.detalle.destroy","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif\/exportar\/{asientosnif}","name":"asientosnif.exportar","action":"App\Http\Controllers\Accounting\AsientoNifController@exportar"},{"host":null,"methods":["POST"],"uri":"asientosnif\/detalle\/evaluate","name":"asientosnif.detalle.evaluate","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@evaluate"},{"host":null,"methods":["POST"],"uri":"asientosnif\/detalle\/validate","name":"asientosnif.detalle.validate","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@validation"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif\/detalle\/movimientos","name":"asientosnif.detalle.movimientos","action":"App\Http\Controllers\Accounting\AsientoNifDetalleController@movimientos"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif","name":"asientosnif.index","action":"App\Http\Controllers\Accounting\AsientoNifController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif\/{asientosnif}","name":"asientosnif.show","action":"App\Http\Controllers\Accounting\AsientoNifController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"asientosnif\/{asientosnif}\/edit","name":"asientosnif.edit","action":"App\Http\Controllers\Accounting\AsientoNifController@edit"},{"host":null,"methods":["PUT"],"uri":"asientosnif\/{asientosnif}","name":"asientosnif.update","action":"App\Http\Controllers\Accounting\AsientoNifController@update"},{"host":null,"methods":["PATCH"],"uri":"asientosnif\/{asientosnif}","name":null,"action":"App\Http\Controllers\Accounting\AsientoNifController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"centroscosto","name":"centroscosto.index","action":"App\Http\Controllers\Accounting\CentroCostoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"centroscosto\/create","name":"centroscosto.create","action":"App\Http\Controllers\Accounting\CentroCostoController@create"},{"host":null,"methods":["POST"],"uri":"centroscosto","name":"centroscosto.store","action":"App\Http\Controllers\Accounting\CentroCostoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"centroscosto\/{centroscosto}","name":"centroscosto.show","action":"App\Http\Controllers\Accounting\CentroCostoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"centroscosto\/{centroscosto}\/edit","name":"centroscosto.edit","action":"App\Http\Controllers\Accounting\CentroCostoController@edit"},{"host":null,"methods":["PUT"],"uri":"centroscosto\/{centroscosto}","name":"centroscosto.update","action":"App\Http\Controllers\Accounting\CentroCostoController@update"},{"host":null,"methods":["PATCH"],"uri":"centroscosto\/{centroscosto}","name":null,"action":"App\Http\Controllers\Accounting\CentroCostoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"folders","name":"folders.index","action":"App\Http\Controllers\Accounting\FolderController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"folders\/create","name":"folders.create","action":"App\Http\Controllers\Accounting\FolderController@create"},{"host":null,"methods":["POST"],"uri":"folders","name":"folders.store","action":"App\Http\Controllers\Accounting\FolderController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"folders\/{folders}","name":"folders.show","action":"App\Http\Controllers\Accounting\FolderController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"folders\/{folders}\/edit","name":"folders.edit","action":"App\Http\Controllers\Accounting\FolderController@edit"},{"host":null,"methods":["PUT"],"uri":"folders\/{folders}","name":"folders.update","action":"App\Http\Controllers\Accounting\FolderController@update"},{"host":null,"methods":["PATCH"],"uri":"folders\/{folders}","name":null,"action":"App\Http\Controllers\Accounting\FolderController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/search","name":"facturas.search","action":"App\Http\Controllers\Receivable\Factura1Controller@search"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/exportar\/{facturas}","name":"facturas.exportar","action":"App\Http\Controllers\Receivable\Factura1Controller@exportar"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/comentario","name":"facturas.comentario.index","action":"App\Http\Controllers\Receivable\Factura3Controller@index"},{"host":null,"methods":["POST"],"uri":"facturas\/comentario","name":"facturas.comentario.store","action":"App\Http\Controllers\Receivable\Factura3Controller@store"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/facturado","name":"facturas.facturado.index","action":"App\Http\Controllers\Receivable\Factura2Controller@index"},{"host":null,"methods":["POST"],"uri":"facturas\/facturado","name":"facturas.facturado.store","action":"App\Http\Controllers\Receivable\Factura2Controller@store"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/detalle","name":"facturas.detalle.index","action":"App\Http\Controllers\Receivable\Factura4Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas","name":"facturas.index","action":"App\Http\Controllers\Receivable\Factura1Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/create","name":"facturas.create","action":"App\Http\Controllers\Receivable\Factura1Controller@create"},{"host":null,"methods":["POST"],"uri":"facturas","name":"facturas.store","action":"App\Http\Controllers\Receivable\Factura1Controller@store"},{"host":null,"methods":["GET","HEAD"],"uri":"facturas\/{facturas}","name":"facturas.show","action":"App\Http\Controllers\Receivable\Factura1Controller@show"},{"host":null,"methods":["GET","HEAD"],"uri":"facturap\/search","name":"facturap.search","action":"App\Http\Controllers\Treasury\FacturapController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"facturap\/cuotas","name":"facturap.cuotas.index","action":"App\Http\Controllers\Treasury\FacturapCuotasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"facturap","name":"facturap.index","action":"App\Http\Controllers\Treasury\FacturapController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"facturap\/{facturap}","name":"facturap.show","action":"App\Http\Controllers\Treasury\FacturapController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/search","name":"ordenes.search","action":"App\Http\Controllers\Production\OrdenpController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/exportar\/{ordenes}","name":"ordenes.exportar","action":"App\Http\Controllers\Production\OrdenpController@exportar"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/cerrar\/{ordenes}","name":"ordenes.cerrar","action":"App\Http\Controllers\Production\OrdenpController@cerrar"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/abrir\/{ordenes}","name":"ordenes.abrir","action":"App\Http\Controllers\Production\OrdenpController@abrir"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/clonar\/{ordenes}","name":"ordenes.clonar","action":"App\Http\Controllers\Production\OrdenpController@clonar"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/tiemposp","name":"ordenes.tiemposp.index","action":"App\Http\Controllers\Production\DetalleTiempospController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/formula","name":"ordenes.productos.formula","action":"App\Http\Controllers\Production\DetalleOrdenpController@formula"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/clonar\/{productos}","name":"ordenes.productos.clonar","action":"App\Http\Controllers\Production\DetalleOrdenpController@clonar"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/search","name":"ordenes.productos.search","action":"App\Http\Controllers\Production\DetalleOrdenpController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/maquinas","name":"ordenes.productos.maquinas.index","action":"App\Http\Controllers\Production\DetalleMaquinasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/materiales","name":"ordenes.productos.materiales.index","action":"App\Http\Controllers\Production\DetalleMaterialesController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/acabados","name":"ordenes.productos.acabados.index","action":"App\Http\Controllers\Production\DetalleAcabadosController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/areas","name":"ordenes.productos.areas.index","action":"App\Http\Controllers\Production\DetalleAreasController@index"},{"host":null,"methods":["POST"],"uri":"ordenes\/productos\/areas","name":"ordenes.productos.areas.store","action":"App\Http\Controllers\Production\DetalleAreasController@store"},{"host":null,"methods":["DELETE"],"uri":"ordenes\/productos\/areas\/{areas}","name":"ordenes.productos.areas.destroy","action":"App\Http\Controllers\Production\DetalleAreasController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos","name":"ordenes.productos.index","action":"App\Http\Controllers\Production\DetalleOrdenpController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/create","name":"ordenes.productos.create","action":"App\Http\Controllers\Production\DetalleOrdenpController@create"},{"host":null,"methods":["POST"],"uri":"ordenes\/productos","name":"ordenes.productos.store","action":"App\Http\Controllers\Production\DetalleOrdenpController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/{productos}","name":"ordenes.productos.show","action":"App\Http\Controllers\Production\DetalleOrdenpController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/productos\/{productos}\/edit","name":"ordenes.productos.edit","action":"App\Http\Controllers\Production\DetalleOrdenpController@edit"},{"host":null,"methods":["PUT"],"uri":"ordenes\/productos\/{productos}","name":"ordenes.productos.update","action":"App\Http\Controllers\Production\DetalleOrdenpController@update"},{"host":null,"methods":["PATCH"],"uri":"ordenes\/productos\/{productos}","name":null,"action":"App\Http\Controllers\Production\DetalleOrdenpController@update"},{"host":null,"methods":["DELETE"],"uri":"ordenes\/productos\/{productos}","name":"ordenes.productos.destroy","action":"App\Http\Controllers\Production\DetalleOrdenpController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/despachos\/exportar\/{despachos}","name":"ordenes.despachos.exportar","action":"App\Http\Controllers\Production\DespachopController@exportar"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/despachos\/pendientes","name":"ordenes.despachos.pendientes","action":"App\Http\Controllers\Production\DespachopController@pendientes"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/despachos","name":"ordenes.despachos.index","action":"App\Http\Controllers\Production\DespachopController@index"},{"host":null,"methods":["POST"],"uri":"ordenes\/despachos","name":"ordenes.despachos.store","action":"App\Http\Controllers\Production\DespachopController@store"},{"host":null,"methods":["DELETE"],"uri":"ordenes\/despachos\/{despachos}","name":"ordenes.despachos.destroy","action":"App\Http\Controllers\Production\DespachopController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes","name":"ordenes.index","action":"App\Http\Controllers\Production\OrdenpController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/create","name":"ordenes.create","action":"App\Http\Controllers\Production\OrdenpController@create"},{"host":null,"methods":["POST"],"uri":"ordenes","name":"ordenes.store","action":"App\Http\Controllers\Production\OrdenpController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/{ordenes}","name":"ordenes.show","action":"App\Http\Controllers\Production\OrdenpController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"ordenes\/{ordenes}\/edit","name":"ordenes.edit","action":"App\Http\Controllers\Production\OrdenpController@edit"},{"host":null,"methods":["PUT"],"uri":"ordenes\/{ordenes}","name":"ordenes.update","action":"App\Http\Controllers\Production\OrdenpController@update"},{"host":null,"methods":["PATCH"],"uri":"ordenes\/{ordenes}","name":null,"action":"App\Http\Controllers\Production\OrdenpController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"actividadesp","name":"actividadesp.index","action":"App\Http\Controllers\Production\ActividadpController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"actividadesp\/create","name":"actividadesp.create","action":"App\Http\Controllers\Production\ActividadpController@create"},{"host":null,"methods":["POST"],"uri":"actividadesp","name":"actividadesp.store","action":"App\Http\Controllers\Production\ActividadpController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"actividadesp\/{actividadesp}","name":"actividadesp.show","action":"App\Http\Controllers\Production\ActividadpController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"actividadesp\/{actividadesp}\/edit","name":"actividadesp.edit","action":"App\Http\Controllers\Production\ActividadpController@edit"},{"host":null,"methods":["PUT"],"uri":"actividadesp\/{actividadesp}","name":"actividadesp.update","action":"App\Http\Controllers\Production\ActividadpController@update"},{"host":null,"methods":["PATCH"],"uri":"actividadesp\/{actividadesp}","name":null,"action":"App\Http\Controllers\Production\ActividadpController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"subactividadesp","name":"subactividadesp.index","action":"App\Http\Controllers\Production\SubActividadpController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"subactividadesp\/create","name":"subactividadesp.create","action":"App\Http\Controllers\Production\SubActividadpController@create"},{"host":null,"methods":["POST"],"uri":"subactividadesp","name":"subactividadesp.store","action":"App\Http\Controllers\Production\SubActividadpController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"subactividadesp\/{subactividadesp}","name":"subactividadesp.show","action":"App\Http\Controllers\Production\SubActividadpController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"subactividadesp\/{subactividadesp}\/edit","name":"subactividadesp.edit","action":"App\Http\Controllers\Production\SubActividadpController@edit"},{"host":null,"methods":["PUT"],"uri":"subactividadesp\/{subactividadesp}","name":"subactividadesp.update","action":"App\Http\Controllers\Production\SubActividadpController@update"},{"host":null,"methods":["PATCH"],"uri":"subactividadesp\/{subactividadesp}","name":null,"action":"App\Http\Controllers\Production\SubActividadpController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tiemposp","name":"tiemposp.index","action":"App\Http\Controllers\Production\TiempopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"tiemposp\/create","name":"tiemposp.create","action":"App\Http\Controllers\Production\TiempopController@create"},{"host":null,"methods":["POST"],"uri":"tiemposp","name":"tiemposp.store","action":"App\Http\Controllers\Production\TiempopController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"tiemposp\/{tiemposp}","name":"tiemposp.show","action":"App\Http\Controllers\Production\TiempopController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"tiemposp\/{tiemposp}\/edit","name":"tiemposp.edit","action":"App\Http\Controllers\Production\TiempopController@edit"},{"host":null,"methods":["PUT"],"uri":"tiemposp\/{tiemposp}","name":"tiemposp.update","action":"App\Http\Controllers\Production\TiempopController@update"},{"host":null,"methods":["PATCH"],"uri":"tiemposp\/{tiemposp}","name":null,"action":"App\Http\Controllers\Production\TiempopController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"areasp","name":"areasp.index","action":"App\Http\Controllers\Production\AreaspController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"areasp\/create","name":"areasp.create","action":"App\Http\Controllers\Production\AreaspController@create"},{"host":null,"methods":["POST"],"uri":"areasp","name":"areasp.store","action":"App\Http\Controllers\Production\AreaspController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"areasp\/{areasp}","name":"areasp.show","action":"App\Http\Controllers\Production\AreaspController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"areasp\/{areasp}\/edit","name":"areasp.edit","action":"App\Http\Controllers\Production\AreaspController@edit"},{"host":null,"methods":["PUT"],"uri":"areasp\/{areasp}","name":"areasp.update","action":"App\Http\Controllers\Production\AreaspController@update"},{"host":null,"methods":["PATCH"],"uri":"areasp\/{areasp}","name":null,"action":"App\Http\Controllers\Production\AreaspController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"acabadosp","name":"acabadosp.index","action":"App\Http\Controllers\Production\AcabadospController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"acabadosp\/create","name":"acabadosp.create","action":"App\Http\Controllers\Production\AcabadospController@create"},{"host":null,"methods":["POST"],"uri":"acabadosp","name":"acabadosp.store","action":"App\Http\Controllers\Production\AcabadospController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"acabadosp\/{acabadosp}","name":"acabadosp.show","action":"App\Http\Controllers\Production\AcabadospController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"acabadosp\/{acabadosp}\/edit","name":"acabadosp.edit","action":"App\Http\Controllers\Production\AcabadospController@edit"},{"host":null,"methods":["PUT"],"uri":"acabadosp\/{acabadosp}","name":"acabadosp.update","action":"App\Http\Controllers\Production\AcabadospController@update"},{"host":null,"methods":["PATCH"],"uri":"acabadosp\/{acabadosp}","name":null,"action":"App\Http\Controllers\Production\AcabadospController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"maquinasp","name":"maquinasp.index","action":"App\Http\Controllers\Production\MaquinaspController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"maquinasp\/create","name":"maquinasp.create","action":"App\Http\Controllers\Production\MaquinaspController@create"},{"host":null,"methods":["POST"],"uri":"maquinasp","name":"maquinasp.store","action":"App\Http\Controllers\Production\MaquinaspController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"maquinasp\/{maquinasp}","name":"maquinasp.show","action":"App\Http\Controllers\Production\MaquinaspController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"maquinasp\/{maquinasp}\/edit","name":"maquinasp.edit","action":"App\Http\Controllers\Production\MaquinaspController@edit"},{"host":null,"methods":["PUT"],"uri":"maquinasp\/{maquinasp}","name":"maquinasp.update","action":"App\Http\Controllers\Production\MaquinaspController@update"},{"host":null,"methods":["PATCH"],"uri":"maquinasp\/{maquinasp}","name":null,"action":"App\Http\Controllers\Production\MaquinaspController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"materialesp","name":"materialesp.index","action":"App\Http\Controllers\Production\MaterialespController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"materialesp\/create","name":"materialesp.create","action":"App\Http\Controllers\Production\MaterialespController@create"},{"host":null,"methods":["POST"],"uri":"materialesp","name":"materialesp.store","action":"App\Http\Controllers\Production\MaterialespController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"materialesp\/{materialesp}","name":"materialesp.show","action":"App\Http\Controllers\Production\MaterialespController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"materialesp\/{materialesp}\/edit","name":"materialesp.edit","action":"App\Http\Controllers\Production\MaterialespController@edit"},{"host":null,"methods":["PUT"],"uri":"materialesp\/{materialesp}","name":"materialesp.update","action":"App\Http\Controllers\Production\MaterialespController@update"},{"host":null,"methods":["PATCH"],"uri":"materialesp\/{materialesp}","name":null,"action":"App\Http\Controllers\Production\MaterialespController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tipomaterialesp","name":"tipomaterialesp.index","action":"App\Http\Controllers\Production\TipoMaterialespController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"tipomaterialesp\/create","name":"tipomaterialesp.create","action":"App\Http\Controllers\Production\TipoMaterialespController@create"},{"host":null,"methods":["POST"],"uri":"tipomaterialesp","name":"tipomaterialesp.store","action":"App\Http\Controllers\Production\TipoMaterialespController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"tipomaterialesp\/{tipomaterialesp}","name":"tipomaterialesp.show","action":"App\Http\Controllers\Production\TipoMaterialespController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"tipomaterialesp\/{tipomaterialesp}\/edit","name":"tipomaterialesp.edit","action":"App\Http\Controllers\Production\TipoMaterialespController@edit"},{"host":null,"methods":["PUT"],"uri":"tipomaterialesp\/{tipomaterialesp}","name":"tipomaterialesp.update","action":"App\Http\Controllers\Production\TipoMaterialespController@update"},{"host":null,"methods":["PATCH"],"uri":"tipomaterialesp\/{tipomaterialesp}","name":null,"action":"App\Http\Controllers\Production\TipoMaterialespController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"tipoproductosp","name":"tipoproductosp.index","action":"App\Http\Controllers\Production\TipoProductopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"tipoproductosp\/create","name":"tipoproductosp.create","action":"App\Http\Controllers\Production\TipoProductopController@create"},{"host":null,"methods":["POST"],"uri":"tipoproductosp","name":"tipoproductosp.store","action":"App\Http\Controllers\Production\TipoProductopController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"tipoproductosp\/{tipoproductosp}","name":"tipoproductosp.show","action":"App\Http\Controllers\Production\TipoProductopController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"tipoproductosp\/{tipoproductosp}\/edit","name":"tipoproductosp.edit","action":"App\Http\Controllers\Production\TipoProductopController@edit"},{"host":null,"methods":["PUT"],"uri":"tipoproductosp\/{tipoproductosp}","name":"tipoproductosp.update","action":"App\Http\Controllers\Production\TipoProductopController@update"},{"host":null,"methods":["PATCH"],"uri":"tipoproductosp\/{tipoproductosp}","name":null,"action":"App\Http\Controllers\Production\TipoProductopController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"subtipoproductosp","name":"subtipoproductosp.index","action":"App\Http\Controllers\Production\SubtipoProductopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"subtipoproductosp\/create","name":"subtipoproductosp.create","action":"App\Http\Controllers\Production\SubtipoProductopController@create"},{"host":null,"methods":["POST"],"uri":"subtipoproductosp","name":"subtipoproductosp.store","action":"App\Http\Controllers\Production\SubtipoProductopController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"subtipoproductosp\/{subtipoproductosp}","name":"subtipoproductosp.show","action":"App\Http\Controllers\Production\SubtipoProductopController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"subtipoproductosp\/{subtipoproductosp}\/edit","name":"subtipoproductosp.edit","action":"App\Http\Controllers\Production\SubtipoProductopController@edit"},{"host":null,"methods":["PUT"],"uri":"subtipoproductosp\/{subtipoproductosp}","name":"subtipoproductosp.update","action":"App\Http\Controllers\Production\SubtipoProductopController@update"},{"host":null,"methods":["PATCH"],"uri":"subtipoproductosp\/{subtipoproductosp}","name":null,"action":"App\Http\Controllers\Production\SubtipoProductopController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/search","name":"cotizaciones.search","action":"App\Http\Controllers\Production\Cotizacion1Controller@search"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/exportar\/{cotizaciones}","name":"cotizaciones.exportar","action":"App\Http\Controllers\Production\Cotizacion1Controller@exportar"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/cerrar\/{cotizaciones}","name":"cotizaciones.cerrar","action":"App\Http\Controllers\Production\Cotizacion1Controller@cerrar"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/abrir\/{cotizaciones}","name":"cotizaciones.abrir","action":"App\Http\Controllers\Production\Cotizacion1Controller@abrir"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/clonar\/{cotizaciones}","name":"cotizaciones.clonar","action":"App\Http\Controllers\Production\Cotizacion1Controller@clonar"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/generar\/{cotizaciones}","name":"cotizaciones.generar","action":"App\Http\Controllers\Production\Cotizacion1Controller@generar"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/formula","name":"cotizaciones.productos.formula","action":"App\Http\Controllers\Production\Cotizacion2Controller@formula"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/clonar\/{productos}","name":"cotizaciones.productos.clonar","action":"App\Http\Controllers\Production\Cotizacion2Controller@clonar"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/maquinas","name":"cotizaciones.productos.maquinas.index","action":"App\Http\Controllers\Production\Cotizacion3Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/materiales","name":"cotizaciones.productos.materiales.index","action":"App\Http\Controllers\Production\Cotizacion4Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/acabados","name":"cotizaciones.productos.acabados.index","action":"App\Http\Controllers\Production\Cotizacion5Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/areas","name":"cotizaciones.productos.areas.index","action":"App\Http\Controllers\Production\Cotizacion6Controller@index"},{"host":null,"methods":["POST"],"uri":"cotizaciones\/productos\/areas","name":"cotizaciones.productos.areas.store","action":"App\Http\Controllers\Production\Cotizacion6Controller@store"},{"host":null,"methods":["DELETE"],"uri":"cotizaciones\/productos\/areas\/{areas}","name":"cotizaciones.productos.areas.destroy","action":"App\Http\Controllers\Production\Cotizacion6Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos","name":"cotizaciones.productos.index","action":"App\Http\Controllers\Production\Cotizacion2Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/create","name":"cotizaciones.productos.create","action":"App\Http\Controllers\Production\Cotizacion2Controller@create"},{"host":null,"methods":["POST"],"uri":"cotizaciones\/productos","name":"cotizaciones.productos.store","action":"App\Http\Controllers\Production\Cotizacion2Controller@store"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/{productos}","name":"cotizaciones.productos.show","action":"App\Http\Controllers\Production\Cotizacion2Controller@show"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/productos\/{productos}\/edit","name":"cotizaciones.productos.edit","action":"App\Http\Controllers\Production\Cotizacion2Controller@edit"},{"host":null,"methods":["PUT"],"uri":"cotizaciones\/productos\/{productos}","name":"cotizaciones.productos.update","action":"App\Http\Controllers\Production\Cotizacion2Controller@update"},{"host":null,"methods":["PATCH"],"uri":"cotizaciones\/productos\/{productos}","name":null,"action":"App\Http\Controllers\Production\Cotizacion2Controller@update"},{"host":null,"methods":["DELETE"],"uri":"cotizaciones\/productos\/{productos}","name":"cotizaciones.productos.destroy","action":"App\Http\Controllers\Production\Cotizacion2Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones","name":"cotizaciones.index","action":"App\Http\Controllers\Production\Cotizacion1Controller@index"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/create","name":"cotizaciones.create","action":"App\Http\Controllers\Production\Cotizacion1Controller@create"},{"host":null,"methods":["POST"],"uri":"cotizaciones","name":"cotizaciones.store","action":"App\Http\Controllers\Production\Cotizacion1Controller@store"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/{cotizaciones}","name":"cotizaciones.show","action":"App\Http\Controllers\Production\Cotizacion1Controller@show"},{"host":null,"methods":["GET","HEAD"],"uri":"cotizaciones\/{cotizaciones}\/edit","name":"cotizaciones.edit","action":"App\Http\Controllers\Production\Cotizacion1Controller@edit"},{"host":null,"methods":["PUT"],"uri":"cotizaciones\/{cotizaciones}","name":"cotizaciones.update","action":"App\Http\Controllers\Production\Cotizacion1Controller@update"},{"host":null,"methods":["PATCH"],"uri":"cotizaciones\/{cotizaciones}","name":null,"action":"App\Http\Controllers\Production\Cotizacion1Controller@update"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/search","name":"productosp.search","action":"App\Http\Controllers\Production\ProductopController@search"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/clonar\/{productosp}","name":"productosp.clonar","action":"App\Http\Controllers\Production\ProductopController@clonar"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/tips","name":"productosp.tips.index","action":"App\Http\Controllers\Production\Productop2Controller@index"},{"host":null,"methods":["POST"],"uri":"productosp\/tips","name":"productosp.tips.store","action":"App\Http\Controllers\Production\Productop2Controller@store"},{"host":null,"methods":["DELETE"],"uri":"productosp\/tips\/{tips}","name":"productosp.tips.destroy","action":"App\Http\Controllers\Production\Productop2Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/areas","name":"productosp.areas.index","action":"App\Http\Controllers\Production\Productop3Controller@index"},{"host":null,"methods":["POST"],"uri":"productosp\/areas","name":"productosp.areas.store","action":"App\Http\Controllers\Production\Productop3Controller@store"},{"host":null,"methods":["DELETE"],"uri":"productosp\/areas\/{areas}","name":"productosp.areas.destroy","action":"App\Http\Controllers\Production\Productop3Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/maquinas","name":"productosp.maquinas.index","action":"App\Http\Controllers\Production\Productop4Controller@index"},{"host":null,"methods":["POST"],"uri":"productosp\/maquinas","name":"productosp.maquinas.store","action":"App\Http\Controllers\Production\Productop4Controller@store"},{"host":null,"methods":["DELETE"],"uri":"productosp\/maquinas\/{maquinas}","name":"productosp.maquinas.destroy","action":"App\Http\Controllers\Production\Productop4Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/materiales","name":"productosp.materiales.index","action":"App\Http\Controllers\Production\Productop5Controller@index"},{"host":null,"methods":["POST"],"uri":"productosp\/materiales","name":"productosp.materiales.store","action":"App\Http\Controllers\Production\Productop5Controller@store"},{"host":null,"methods":["DELETE"],"uri":"productosp\/materiales\/{materiales}","name":"productosp.materiales.destroy","action":"App\Http\Controllers\Production\Productop5Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/acabados","name":"productosp.acabados.index","action":"App\Http\Controllers\Production\Productop6Controller@index"},{"host":null,"methods":["POST"],"uri":"productosp\/acabados","name":"productosp.acabados.store","action":"App\Http\Controllers\Production\Productop6Controller@store"},{"host":null,"methods":["DELETE"],"uri":"productosp\/acabados\/{acabados}","name":"productosp.acabados.destroy","action":"App\Http\Controllers\Production\Productop6Controller@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp","name":"productosp.index","action":"App\Http\Controllers\Production\ProductopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/create","name":"productosp.create","action":"App\Http\Controllers\Production\ProductopController@create"},{"host":null,"methods":["POST"],"uri":"productosp","name":"productosp.store","action":"App\Http\Controllers\Production\ProductopController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/{productosp}","name":"productosp.show","action":"App\Http\Controllers\Production\ProductopController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"productosp\/{productosp}\/edit","name":"productosp.edit","action":"App\Http\Controllers\Production\ProductopController@edit"},{"host":null,"methods":["PUT"],"uri":"productosp\/{productosp}","name":"productosp.update","action":"App\Http\Controllers\Production\ProductopController@update"},{"host":null,"methods":["PATCH"],"uri":"productosp\/{productosp}","name":null,"action":"App\Http\Controllers\Production\ProductopController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"grupos","name":"grupos.index","action":"App\Http\Controllers\Inventory\GrupoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"grupos\/create","name":"grupos.create","action":"App\Http\Controllers\Inventory\GrupoController@create"},{"host":null,"methods":["POST"],"uri":"grupos","name":"grupos.store","action":"App\Http\Controllers\Inventory\GrupoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"grupos\/{grupos}","name":"grupos.show","action":"App\Http\Controllers\Inventory\GrupoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"grupos\/{grupos}\/edit","name":"grupos.edit","action":"App\Http\Controllers\Inventory\GrupoController@edit"},{"host":null,"methods":["PUT"],"uri":"grupos\/{grupos}","name":"grupos.update","action":"App\Http\Controllers\Inventory\GrupoController@update"},{"host":null,"methods":["PATCH"],"uri":"grupos\/{grupos}","name":null,"action":"App\Http\Controllers\Inventory\GrupoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"subgrupos","name":"subgrupos.index","action":"App\Http\Controllers\Inventory\SubGrupoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"subgrupos\/create","name":"subgrupos.create","action":"App\Http\Controllers\Inventory\SubGrupoController@create"},{"host":null,"methods":["POST"],"uri":"subgrupos","name":"subgrupos.store","action":"App\Http\Controllers\Inventory\SubGrupoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"subgrupos\/{subgrupos}","name":"subgrupos.show","action":"App\Http\Controllers\Inventory\SubGrupoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"subgrupos\/{subgrupos}\/edit","name":"subgrupos.edit","action":"App\Http\Controllers\Inventory\SubGrupoController@edit"},{"host":null,"methods":["PUT"],"uri":"subgrupos\/{subgrupos}","name":"subgrupos.update","action":"App\Http\Controllers\Inventory\SubGrupoController@update"},{"host":null,"methods":["PATCH"],"uri":"subgrupos\/{subgrupos}","name":null,"action":"App\Http\Controllers\Inventory\SubGrupoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"unidades","name":"unidades.index","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"unidades\/create","name":"unidades.create","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@create"},{"host":null,"methods":["POST"],"uri":"unidades","name":"unidades.store","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"unidades\/{unidades}","name":"unidades.show","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"unidades\/{unidades}\/edit","name":"unidades.edit","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@edit"},{"host":null,"methods":["PUT"],"uri":"unidades\/{unidades}","name":"unidades.update","action":"App\Http\Controllers\Inventory\UnidadesMedidaController@update"},{"host":null,"methods":["PATCH"],"uri":"unidades\/{unidades}","name":null,"action":"App\Http\Controllers\Inventory\UnidadesMedidaController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"traslados\/detalle","name":"traslados.detalle.index","action":"App\Http\Controllers\Inventory\DetalleTrasladoController@index"},{"host":null,"methods":["POST"],"uri":"traslados\/detalle","name":"traslados.detalle.store","action":"App\Http\Controllers\Inventory\DetalleTrasladoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"traslados","name":"traslados.index","action":"App\Http\Controllers\Inventory\TrasladosController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"traslados\/create","name":"traslados.create","action":"App\Http\Controllers\Inventory\TrasladosController@create"},{"host":null,"methods":["POST"],"uri":"traslados","name":"traslados.store","action":"App\Http\Controllers\Inventory\TrasladosController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"traslados\/{traslados}","name":"traslados.show","action":"App\Http\Controllers\Inventory\TrasladosController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/search","name":"productos.search","action":"App\Http\Controllers\Inventory\ProductoController@search"},{"host":null,"methods":["POST"],"uri":"productos\/evaluate","name":"productos.evaluate","action":"App\Http\Controllers\Inventory\ProductoController@evaluate"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/rollos","name":"productos.rollos.index","action":"App\Http\Controllers\Inventory\ProdbodeRolloController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/prodbode","name":"productos.prodbode.index","action":"App\Http\Controllers\Inventory\ProdBodeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"productos","name":"productos.index","action":"App\Http\Controllers\Inventory\ProductoController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/create","name":"productos.create","action":"App\Http\Controllers\Inventory\ProductoController@create"},{"host":null,"methods":["POST"],"uri":"productos","name":"productos.store","action":"App\Http\Controllers\Inventory\ProductoController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/{productos}","name":"productos.show","action":"App\Http\Controllers\Inventory\ProductoController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"productos\/{productos}\/edit","name":"productos.edit","action":"App\Http\Controllers\Inventory\ProductoController@edit"},{"host":null,"methods":["PUT"],"uri":"productos\/{productos}","name":"productos.update","action":"App\Http\Controllers\Inventory\ProductoController@update"},{"host":null,"methods":["PATCH"],"uri":"productos\/{productos}","name":null,"action":"App\Http\Controllers\Inventory\ProductoController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"rplancuentas","name":"rplancuentas.index","action":"App\Http\Controllers\Report\PlanCuentasController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"rmayorbalance","name":"rmayorbalance.index","action":"App\Http\Controllers\Report\MayorBalanceController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"rtiemposp","name":"rtiemposp.index","action":"App\Http\Controllers\Report\TiempopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"rhistorialproveedores","name":"rhistorialproveedores.index","action":"App\Http\Controllers\Report\HistorialProveedorController@index"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // Route.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // Route.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // Route.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // Route.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // Route.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // Route.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.Route = laroute;
    }

}).call(this);


/**
* Class AppRouter  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AppRouter = new( Backbone.Router.extend({
        routes : {
            'login(/)': 'getLogin',
            'terceros(/)': 'getTercerosMain',
            'terceros/create(/)': 'getTercerosCreate',
            'terceros/:tercero(/)': 'getTercerosShow',
            'terceros/:tercero/edit(/)': 'getTercerosEdit',

            'empresa(/)': 'getEmpresaEdit',
            'municipios(/)': 'getMunicipiosMain',
            'departamentos(/)': 'getDepartamentosMain',

            'actividades(/)': 'getActividadesMain',
            'actividades/create(/)': 'getActividadesCreate',
            'actividades/:actividad/edit(/)': 'getActividadesEdit',

            'sucursales(/)': 'getSucursalesMain',
            'sucursales/create(/)': 'getSucursalesCreate',
            'sucursales/:sucursal/edit(/)': 'getSucursalesEdit',

            'roles(/)': 'getRolesMain',
            'roles/create(/)': 'getRolesCreate',
            'roles/:rol/edit(/)': 'getRolesEdit',

            'permisos(/)': 'getPermisosMain',
            'modulos(/)': 'getModulosMain',

            'puntosventa(/)': 'getPuntosVentaMain',
            'puntosventa/create(/)': 'getPuntosVentaCreate',
            'puntosventa/:puntoventa/edit(/)': 'getPuntosVentaEdit',

            // Cartera
            'facturas(/)': 'getFacturasMain',
            'facturas/create(/)': 'getFacturaCreate',
            'facturas/:facturas(/)': 'getFacturaShow',

            // Contabilidad
            'plancuentas(/)': 'getPlanCuentasMain',
            'plancuentas/create(/)': 'getPlanCuentasCreate',
            'plancuentas/:plancuenta/edit(/)': 'getPlanCuentasEdit',

            'plancuentasnif(/)': 'getPlanCuentasNifMain',
            'plancuentasnif/create(/)': 'getPlanCuentasNifCreate',
            'plancuentasnif/:plancuentanif/edit(/)': 'getPlanCuentasNifEdit',

            'centroscosto(/)': 'getCentrosCostoMain',
            'centroscosto/create(/)': 'getCentrosCostoCreate',
            'centroscosto/:centrocosto/edit(/)': 'getCentrosCostoEdit',

            'asientos(/)': 'getAsientosMain',
            'asientos/create(/)': 'getAsientosCreate',
            'asientos/:asientos(/)': 'getAsientosShow',
            'asientos/:asiento/edit(/)': 'getAsientosEdit',

            'asientosnif(/)': 'getAsientosNifMain',
            'asientosnif/:asientonif(/)': 'getAsientosNifShow',
            'asientosnif/:asientonif/edit(/)': 'getAsientosNifEdit',

            'documentos(/)': 'getDocumentosMain',
            'documentos/create(/)': 'getDocumentosCreate',
            'documentos/:documento/edit(/)':'getDocumentosEdit',

            'folders(/)': 'getFoldersMain',
            'folders/create(/)': 'getFoldersCreate',
            'folders/:folder/edit(/)':'getFoldersEdit',

            // Inventario
            'subgrupos(/)': 'getSubGruposMain',
            'subgrupos/create(/)': 'getSubGruposCreate',
            'subgrupos/:subgrupo/edit(/)': 'getSubGruposEdit',

            'grupos(/)': 'getGruposMain',
            'grupos/create(/)': 'getGruposCreate',
            'grupos/:grupo/edit(/)': 'getGruposEdit',

            'unidades(/)': 'getUnidadesMain',
            'unidades/create(/)': 'getUnidadesCreate',
            'unidades/:unidad/edit(/)': 'getUnidadesEdit',

            'productos(/)': 'getProductosMain',
            'productos/create(/)': 'getProductosCreate',
            'productos/:producto(/)': 'getProductoShow',
            'productos/:producto/edit(/)': 'getProductosEdit',

            'traslados(/)': 'getTrasladosMain',
            'traslados/create(/)': 'getTrasladosCreate',
            'traslados/:traslado(/)': 'getTrasladosShow',

            // Produccion
            'tiemposp(/)': 'getTiempopMain',

            'areasp(/)': 'getAreaspMain',
            'areasp/create(/)': 'getAreaspCreate',
            'areasp/:areap/edit(/)': 'getAreaspEdit',

            'actividadesp(/)': 'getActividadespMain',
            'actividadesp/create(/)': 'getActividadespCreate',
            'actividadesp/:actividadp/edit(/)': 'getActividadespEdit',

            'subactividadesp(/)': 'getSubActividadespMain',
            'subactividadesp/create(/)': 'getSubActividadespCreate',
            'subactividadesp/:subactividadp/edit(/)': 'getSubActividadespEdit',

            'acabadosp(/)': 'getAcabadospMain',
            'acabadosp/create(es/)':'getAcabadospCreate',
            'acabadosp/:acabadop/edit(/)': 'getAcabadospEdit',

            'maquinasp(/)': 'getMaquinaspMain',
            'maquinasp/create(/)': 'getMaquinaspCreate',
            'maquinasp/:maquinap/edit(/)': 'getMaquinaspEdit',

            'materialesp(/)': 'getMaterialespMain',
            'materialesp/create(/)': 'getMaterialespCreate',
            'materialesp/:materialp/edit(/)': 'getMaterialespEdit',

            'tipomaterialesp(/)': 'getTipoMaterialespMain',
            'tipomaterialesp/create(/)': 'getTipoMaterialpCreate',
            'tipomaterialesp/:tipomaterialesp/edit(/)': 'getTipoMaterialpEdit',

            'tipoproductosp(/)': 'getTipoProductopMain',
            'tipoproductosp/create(/)': 'getTipoProductopCreate',
            'tipoproductosp/:tipoproductosp/edit(/)': 'getTipoProductopEdit',

            'subtipoproductosp(/)': 'getSubtipoProductopMain',
            'subtipoproductosp/create(/)': 'getSubtipoProductopCreate',
            'subtipoproductosp/:subtipoproductosp/edit(/)': 'getSubtipoProductopEdit',

            'ordenes(/)': 'getOrdenesMain',
            'ordenes/create(/)': 'getOrdenesCreate',
            'ordenes/:orden(/)': 'getOrdenesShow',
            'ordenes/:orden/edit(/)': 'getOrdenesEdit',
            'ordenes/productos/create(/)(?*queryString)': 'getOrdenesProductoCreate',
            'ordenes/productos/:producto/edit(/)': 'getOrdenesProductoEdit',

            'productosp(/)': 'getProductospMain',
            'productosp/create(/)': 'getProductospCreate',
            'productosp/:producto(/)': 'getProductospShow',
            'productosp/:producto/edit(/)': 'getProductospEdit',

            'cotizaciones(/)': 'getCotizacionesMain',
            'cotizaciones/create(/)': 'getCotizacionesCreate',
            'cotizaciones/:cotizaciones(/)': 'getCotizacionesShow',
            'cotizaciones/:cotizaciones/edit(/)': 'getCotizacionesEdit',
            'cotizaciones/productos/create(/)(?*queryString)': 'getCotizacionesProductoCreate',
            'cotizaciones/productos/:producto/edit(/)': 'getCotizacionesProductoEdit',

            // Treasury
            'facturap(/)': 'getFacturaspMain',
            'facturap(/):facturap(/)': 'getFacturaspShow',
        },

        /**
        * Parse queryString to object
        */
        parseQueryString : function(queryString) {
            var params = {};
            if(queryString) {
                _.each(
                    _.map(decodeURI(queryString).split(/&/g),function(el,i){
                        var aux = el.split('='), o = {};
                        if(aux.length >= 1){
                            var val = undefined;
                            if(aux.length == 2)
                                val = aux[1];
                            o[aux[0]] = val;
                        }
                        return o;
                    }),
                    function(o){
                        _.extend(params,o);
                    }
                );
            }
            return params;
        },

        /**
        * Constructor Method
        */
        initialize : function ( opts ){
            // Initialize resources
            this.componentGlobalView = new app.ComponentGlobalView();
            this.componentAddressView = new app.ComponentAddressView();
            this.componentCreateResourceView = new app.ComponentCreateResourceView();
            this.componentSearchTerceroView = new app.ComponentSearchTerceroView();
            this.componentSearchCuentaView = new app.ComponentSearchCuentaView();
            this.componentDocumentView = new app.ComponentDocumentView();
            this.componentReportView = new app.ComponentReportView();
            this.componentTerceroView = new app.ComponentTerceroView();
            this.componentSearchFacturaView = new app.ComponentSearchFacturaView();
            this.componentSearchOrdenPView = new app.ComponentSearchOrdenPView();
            this.componentSearchOrdenP2View = new app.ComponentSearchOrdenP2View();
            this.componentSearchProductoView = new app.ComponentSearchProductoView();
            this.componentSearchProductopView = new app.ComponentSearchProductopView();
            this.componentSearchContactoView = new app.ComponentSearchContactoView();
            this.componentConsecutiveView = new app.ComponentConsecutiveView();
      	},

        /**
        * Start Backbone history
        */
        start: function () {
            var config = { pushState: true };

            if( document.domain.search(/(104.236.57.82|localhost)/gi) != '-1' ) {
                config.root = '/vaziko/public/';
            }

            Backbone.history.start( config );
        },

        /**
        * show view in Calendar Event
        * @param String show
        */
        getLogin: function () {

            if ( this.loginView instanceof Backbone.View ){
                this.loginView.stopListening();
                this.loginView.undelegateEvents();
            }

            this.loginView = new app.UserLoginView( );
        },

        /**
        * show view main terceros
        */
        getTercerosMain: function () {

            if ( this.mainTerceroView instanceof Backbone.View ){
                this.mainTerceroView.stopListening();
                this.mainTerceroView.undelegateEvents();
            }

            this.mainTerceroView = new app.MainTerceroView( );
        },

        /**
        * show view create terceros
        */
        getTercerosCreate: function () {
            this.terceroModel = new app.TerceroModel();

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            this.createTerceroView = new app.CreateTerceroView({ model: this.terceroModel });
            this.createTerceroView.render();
        },

        /**
        * show view show tercero
        */
        getTercerosShow: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.showTerceroView instanceof Backbone.View ){
                this.showTerceroView.stopListening();
                this.showTerceroView.undelegateEvents();
            }

            this.showTerceroView = new app.ShowTerceroView({ model: this.terceroModel });
        },

        /**
        * show view edit terceros
        */
        getTercerosEdit: function (tercero) {
            this.terceroModel = new app.TerceroModel();
            this.terceroModel.set({'id': tercero}, {'silent':true});

            if ( this.createTerceroView instanceof Backbone.View ){
                this.createTerceroView.stopListening();
                this.createTerceroView.undelegateEvents();
            }

            this.createTerceroView = new app.CreateTerceroView({ model: this.terceroModel });
            this.terceroModel.fetch();
        },

        /**
        * show view edit empresa
        */
        getEmpresaEdit: function () {
            this.empresaModel = new app.EmpresaModel();

            if ( this.createEmpresaView instanceof Backbone.View ){
                this.createEmpresaView.stopListening();
                this.createEmpresaView.undelegateEvents();
            }

            this.createEmpresaView = new app.CreateEmpresaView({ model: this.empresaModel });
            this.empresaModel.fetch();
        },

        /**
        * show view main municipios
        */
        getMunicipiosMain: function () {

            if ( this.mainMunicipioView instanceof Backbone.View ){
                this.mainMunicipioView.stopListening();
                this.mainMunicipioView.undelegateEvents();
            }

            this.mainMunicipioView = new app.MainMunicipioView( );
        },

        /**
        * show view main departamentos
        */
        getDepartamentosMain: function () {

            if ( this.mainDepartamentoView instanceof Backbone.View ){
                this.mainDepartamentoView.stopListening();
                this.mainDepartamentoView.undelegateEvents();
            }

            this.mainDepartamentoView = new app.MainDepartamentoView( );
        },

        /**
        * show view main actividades
        */
        getActividadesMain: function () {

            if ( this.mainActividadView instanceof Backbone.View ){
                this.mainActividadView.stopListening();
                this.mainActividadView.undelegateEvents();
            }

            this.mainActividadView = new app.MainActividadView( );
        },

        /**
        * show view create actividades
        */
        getActividadesCreate: function () {
            this.actividadModel = new app.ActividadModel();

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.createActividadView.render();
        },

        /**
        * show view edit actividades
        */
        getActividadesEdit: function (actividad) {
            this.actividadModel = new app.ActividadModel();
            this.actividadModel.set({'id': actividad}, {silent: true});

            if ( this.createActividadView instanceof Backbone.View ){
                this.createActividadView.stopListening();
                this.createActividadView.undelegateEvents();
            }

            this.createActividadView = new app.CreateActividadView({ model: this.actividadModel });
            this.actividadModel.fetch();
        },

        /**
        * show view main sucursales
        */
        getSucursalesMain: function () {

            if ( this.mainSucursalesView instanceof Backbone.View ){
                this.mainSucursalesView.stopListening();
                this.mainSucursalesView.undelegateEvents();
            }

            this.mainSucursalesView = new app.MainSucursalesView( );
        },

        /**
        * show view create sucursales
        */
        getSucursalesCreate: function () {
            this.sucursalModel = new app.SucursalModel();

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.createSucursalView.render();
        },

        /**
        * show view edit sucursales
        */
        getSucursalesEdit: function (sucursal) {
            this.sucursalModel = new app.SucursalModel();
            this.sucursalModel.set({'id': sucursal}, {silent: true});

            if ( this.createSucursalView instanceof Backbone.View ){
                this.createSucursalView.stopListening();
                this.createSucursalView.undelegateEvents();
            }

            this.createSucursalView = new app.CreateSucursalView({ model: this.sucursalModel });
            this.sucursalModel.fetch();
        },

        /**
        * show view main roles
        */
        getRolesMain: function () {

            if ( this.mainRolesView instanceof Backbone.View ){
                this.mainRolesView.stopListening();
                this.mainRolesView.undelegateEvents();
            }

            this.mainRolesView = new app.MainRolesView( );
        },

        /**
        * show view create roles
        */
        getRolesCreate: function () {
            this.rolModel = new app.RolModel();

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.createRolView = new app.CreateRolView({ model: this.rolModel });
            this.createRolView.render();
        },

        /**
        * show view edit roles
        */
        getRolesEdit: function (rol) {
            this.rolModel = new app.RolModel();
            this.rolModel.set({'id': rol}, {silent: true});

            if ( this.editRolView instanceof Backbone.View ){
                this.editRolView.stopListening();
                this.editRolView.undelegateEvents();
            }

            if ( this.createRolView instanceof Backbone.View ){
                this.createRolView.stopListening();
                this.createRolView.undelegateEvents();
            }

            this.editRolView = new app.EditRolView({ model: this.rolModel });
            this.rolModel.fetch();
        },

        /**
        * show main view permisos
        */
        getPermisosMain: function () {

            if ( this.mainPermisoView instanceof Backbone.View ){
                this.mainPermisoView.stopListening();
                this.mainPermisoView.undelegateEvents();
            }

            this.mainPermisoView = new app.MainPermisoView( );
        },

        /**
        * show main view modulos
        */
        getModulosMain: function () {

            if ( this.mainModuloView instanceof Backbone.View ){
                this.mainModuloView.stopListening();
                this.mainModuloView.undelegateEvents();
            }

            this.mainModuloView = new app.MainModuloView( );
        },

        /**
        * show view main puntos de venta
        */
        getPuntosVentaMain: function () {

            if ( this.mainPuntoventaView instanceof Backbone.View ){
                this.mainPuntoventaView.stopListening();
                this.mainPuntoventaView.undelegateEvents();
            }

            this.mainPuntoventaView = new app.MainPuntoventaView( );
        },

        /**
        * show view create puntos de venta
        */
        getPuntosVentaCreate: function () {
            this.puntoVentaModel = new app.PuntoVentaModel();

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.createPuntoventaView.render();
        },

        /**
        * show view edit puntos de venta
        */
        getPuntosVentaEdit: function (puntoventa) {
            this.puntoVentaModel = new app.PuntoVentaModel();
            this.puntoVentaModel.set({'id': puntoventa}, {silent: true});

            if ( this.createPuntoventaView instanceof Backbone.View ){
                this.createPuntoventaView.stopListening();
                this.createPuntoventaView.undelegateEvents();
            }

            this.createPuntoventaView = new app.CreatePuntoventaView({ model: this.puntoVentaModel });
            this.puntoVentaModel.fetch();
        },

        /**
        * show view main plan de cuentas
        */
        getPlanCuentasMain: function () {

            if ( this.mainPlanCuentasView instanceof Backbone.View ){
                this.mainPlanCuentasView.stopListening();
                this.mainPlanCuentasView.undelegateEvents();
            }

            this.mainPlanCuentasView = new app.MainPlanCuentasView( );
        },

        /**
        * show view create cuenta contable
        */
        getPlanCuentasCreate: function () {
            this.planCuentaModel = new app.PlanCuentaModel();

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.createPlanCuentaView.render();
        },

        /**
        * show view edit cuenta contable
        */
        getPlanCuentasEdit: function (plancuenta) {
            this.planCuentaModel = new app.PlanCuentaModel();
            this.planCuentaModel.set({'id': plancuenta}, {silent: true});

            if ( this.createPlanCuentaView instanceof Backbone.View ){
                this.createPlanCuentaView.stopListening();
                this.createPlanCuentaView.undelegateEvents();
            }

            this.createPlanCuentaView = new app.CreatePlanCuentaView({ model: this.planCuentaModel });
            this.planCuentaModel.fetch();
        },

        /**
        * show view main cuenta NIF contable
        */
        getPlanCuentasNifMain: function () {

            if ( this.mainPlanCuentasNifView instanceof Backbone.View ){
                this.mainPlanCuentasNifView.stopListening();
                this.mainPlanCuentasNifView.undelegateEvents();
            }

            this.mainPlanCuentasNifView = new app.MainPlanCuentasNifView( );
        },
        /**
        * show view create cuenta NIF contable
        */
        getPlanCuentasNifCreate: function () {
            this.planCuentaNifModel = new app.PlanCuentaNifModel();

            if ( this.createPlanCuentaNifView instanceof Backbone.View ){
                this.createPlanCuentaNifView.stopListening();
                this.createPlanCuentaNifView.undelegateEvents();
            }

            this.createPlanCuentaNifView = new app.CreatePlanCuentaNifView({ model: this.planCuentaNifModel });
            this.createPlanCuentaNifView.render();
        },
        /**
        * show view edit cuenta NIF contable
        */
        getPlanCuentasNifEdit: function (plancuentanif) {
            this.planCuentaNifModel = new app.PlanCuentaNifModel();
            this.planCuentaNifModel.set({'id': plancuentanif}, {silent: true});

            if ( this.createPlanCuentaNifView instanceof Backbone.View ){
                this.createPlanCuentaNifView.stopListening();
                this.createPlanCuentaNifView.undelegateEvents();
            }

            this.createPlanCuentaNifView = new app.CreatePlanCuentaNifView({ model: this.planCuentaNifModel });
            this.planCuentaNifModel.fetch();
        },
        /**
        * show view main centros de costo
        */
        getCentrosCostoMain: function () {

            if ( this.mainCentrosCostoView instanceof Backbone.View ){
                this.mainCentrosCostoView.stopListening();
                this.mainCentrosCostoView.undelegateEvents();
            }

            this.mainCentrosCostoView = new app.MainCentrosCostoView( );
        },

        /**
        * show view create centro de costo
        */
        getCentrosCostoCreate: function () {
            this.centroCostoModel = new app.CentroCostoModel();

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.createCentroCostoView.render();
        },

        /**
        * show view edit centro de costo
        */
        getCentrosCostoEdit: function (centrocosto) {
            this.centroCostoModel = new app.CentroCostoModel();
            this.centroCostoModel.set({'id': centrocosto}, {silent: true});

            if ( this.createCentroCostoView instanceof Backbone.View ){
                this.createCentroCostoView.stopListening();
                this.createCentroCostoView.undelegateEvents();
            }

            this.createCentroCostoView = new app.CreateCentroCostoView({ model: this.centroCostoModel, parameters: { callback: 'toShow' } });
            this.centroCostoModel.fetch();
        },

        /**
        * show view main asientos contables
        */
        getAsientosMain: function () {

            if ( this.mainAsientosView instanceof Backbone.View ){
                this.mainAsientosView.stopListening();
                this.mainAsientosView.undelegateEvents();
            }

            this.mainAsientosView = new app.MainAsientosView( );
        },

        /**
        * show view create asiento contable
        */
        getAsientosCreate: function () {
            this.asientoModel = new app.AsientoModel();

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.createAsientoView = new app.CreateAsientoView({ model: this.asientoModel });
            this.createAsientoView.render();
        },

        /**
        * show view show asiento contable
        */
        getAsientosShow: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.showAsientoView instanceof Backbone.View ){
                this.showAsientoView.stopListening();
                this.showAsientoView.undelegateEvents();
            }

            this.showAsientoView = new app.ShowAsientoView({ model: this.asientoModel });
        },

        /**
        * show view edit asiento contable
        */
        getAsientosEdit: function (asiento) {
            this.asientoModel = new app.AsientoModel();
            this.asientoModel.set({'id': asiento}, {'silent':true});

            if ( this.editAsientoView instanceof Backbone.View ){
                this.editAsientoView.stopListening();
                this.editAsientoView.undelegateEvents();
            }

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.editAsientoView = new app.EditAsientoView({ model: this.asientoModel });
            this.asientoModel.fetch();
        },
        /**
        * show view main asiento NIF contable
        */
        getAsientosNifMain: function () {

            if ( this.mainAsientosNifView instanceof Backbone.View ){
                this.mainAsientosNifView.stopListening();
                this.mainAsientosNifView.undelegateEvents();
            }

            this.mainAsientosNifView = new app.MainAsientosNifView( );
        },
        /**
        * show view show asiento NIF contable
        */
        getAsientosNifShow: function (asientoNif) {
            this.asientoNifModel = new app.AsientoNifModel();
            this.asientoNifModel.set({'id': asientoNif}, {'silent':true});

            if ( this.showAsientoNifView instanceof Backbone.View ){
                this.showAsientoNifView.stopListening();
                this.showAsientoNifView.undelegateEvents();
            }

            this.showAsientoNifView = new app.ShowAsientoNifView({ model: this.asientoNifModel });
        },
        /**
        * show view edit asiento NIF contable
        */
        getAsientosNifEdit: function (asientoNif) {
            this.asientoNifModel = new app.AsientoNifModel();
            this.asientoNifModel.set({'id': asientoNif}, {'silent':true});

            if ( this.editAsientoNifView instanceof Backbone.View ){
                this.editAsientoNifView.stopListening();
                this.editAsientoNifView.undelegateEvents();
            }

            if ( this.createAsientoView instanceof Backbone.View ){
                this.createAsientoView.stopListening();
                this.createAsientoView.undelegateEvents();
            }

            this.editAsientoNifView = new app.EditAsientoNifView({ model: this.asientoNifModel });
            this.asientoNifModel.fetch();
        },
        /**
        * show view show folders
        */
        getFoldersMain: function () {

            if ( this.mainFoldersView instanceof Backbone.View ){
                this.mainFoldersView.stopListening();
                this.mainFoldersView.undelegateEvents();
            }

            this.mainFoldersView = new app.MainFoldersView( );
        },

        /**
        * show view create folders
        */
        getFoldersCreate: function () {
            this.folderModel = new app.FolderModel();

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.createFolderView.render();
        },

        /**
        * show view edit folder
        */
        getFoldersEdit: function (folder) {
            this.folderModel = new app.FolderModel();
            this.folderModel.set({'id': folder}, {silent: true});

            if ( this.createFolderView instanceof Backbone.View ){
                this.createFolderView.stopListening();
                this.createFolderView.undelegateEvents();
            }

            this.createFolderView = new app.CreateFolderView({ model: this.folderModel });
            this.folderModel.fetch();
        },

        /**
        * show view main documentos
        */
        getDocumentosMain: function () {
            if ( this.mainDocumentosView instanceof Backbone.View ){
                this.mainDocumentosView.stopListening();
                this.mainDocumentosView.undelegateEvents();
            }

            this.mainDocumentosView = new app.MainDocumentosView( );
        },

        /**
        * show view create documento
        */
        getDocumentosCreate: function () {
            this.documentoModel = new app.DocumentoModel();

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.createDocumentoView.render();
        },

        /**
        * show view edit documento
        */
        getDocumentosEdit: function (documento) {
            this.documentoModel = new app.DocumentoModel();
            this.documentoModel.set({'id': documento}, {silent: true});

            if ( this.createDocumentoView instanceof Backbone.View ){
                this.createDocumentoView.stopListening();
                this.createDocumentoView.undelegateEvents();
            }

            this.createDocumentoView = new app.CreateDocumentoView({ model: this.documentoModel });
            this.documentoModel.fetch();
        },

        /**
        * show view main subgrupos
        */
        getSubGruposMain: function () {

            if ( this.mainSubGruposView instanceof Backbone.View ){
                this.mainSubGruposView.stopListening();
                this.mainSubGruposView.undelegateEvents();
            }

            this.mainSubGruposView = new app.MainSubGruposView( );
        },

        /**
        * show view create subgrupo
        */
        getSubGruposCreate: function () {
            this.subGrupoModel = new app.SubGrupoModel();

            if ( this.createSubGrupoView instanceof Backbone.View ){
                this.createSubGrupoView.stopListening();
                this.createSubGrupoView.undelegateEvents();
            }

            this.createSubGrupoView = new app.CreateSubGrupoView({ model: this.subGrupoModel });
            this.createSubGrupoView.render();
        },

        /**
        * show view edit subgrupo
        */
        getSubGruposEdit: function (subgrupo) {
            this.subGrupoModel = new app.SubGrupoModel();
            this.subGrupoModel.set({'id': subgrupo}, {silent: true});

            if ( this.createSubGrupoView instanceof Backbone.View ){
                this.createSubGrupoView.stopListening();
                this.createSubGrupoView.undelegateEvents();
            }

            this.createSubGrupoView = new app.CreateSubGrupoView({ model: this.subGrupoModel });
            this.subGrupoModel.fetch();
        },

        /**
        * show view main grupos
        */
        getGruposMain: function () {

            if ( this.mainGruposView instanceof Backbone.View ){
                this.mainGruposView.stopListening();
                this.mainGruposView.undelegateEvents();
            }

            this.mainGruposView = new app.MainGruposView( );
        },

        /**
        * show view create grupo
        */
        getGruposCreate: function () {
            this.grupoModel = new app.GrupoModel();

            if ( this.createGrupoView instanceof Backbone.View ){
                this.createGrupoView.stopListening();
                this.createGrupoView.undelegateEvents();
            }

            this.createGrupoView = new app.CreateGrupoView({ model: this.grupoModel });
            this.createGrupoView.render();
        },

        /**
        * show view edit grupo
        */
        getGruposEdit: function (grupo) {
            this.grupoModel = new app.GrupoModel();
            this.grupoModel.set({'id': grupo}, {silent: true});

            if ( this.createGrupoView instanceof Backbone.View ){
                this.createGrupoView.stopListening();
                this.createGrupoView.undelegateEvents();
            }

            this.createGrupoView = new app.CreateGrupoView({ model: this.grupoModel });
            this.grupoModel.fetch();
        },

        /**
        * show view main unidades de medida
        */
        getUnidadesMain: function () {

            if ( this.mainUnidadesView instanceof Backbone.View ){
                this.mainUnidadesView.stopListening();
                this.mainUnidadesView.undelegateEvents();
            }

            this.mainUnidadesView = new app.MainUnidadesView( );
        },

        /**
        * show view create unidad de medida
        */
        getUnidadesCreate: function () {
            this.unidadModel = new app.UnidadModel();

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.createUnidadView.render();
        },

        /**
        * show view edit unidad de medida
        */
        getUnidadesEdit: function (unidad) {
            this.unidadModel = new app.UnidadModel();
            this.unidadModel.set({'id': unidad}, {silent: true});

            if ( this.createUnidadView instanceof Backbone.View ){
                this.createUnidadView.stopListening();
                this.createUnidadView.undelegateEvents();
            }

            this.createUnidadView = new app.CreateUnidadView({ model: this.unidadModel });
            this.unidadModel.fetch();
        },

        /**
        * show view main productos
        */
        getProductosMain: function () {

            if ( this.mainProductosView instanceof Backbone.View ){
                this.mainProductosView.stopListening();
                this.mainProductosView.undelegateEvents();
            }

            this.mainProductosView = new app.MainProductosView( );
        },

        /**
        * show view create producto
        */
        getProductosCreate: function () {
            this.productoModel = new app.ProductoModel();

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.createProductoView.render();
        },

        /**
        * show view show producto
        */
        getProductoShow: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {'silent':true});

            if ( this.showProductoView instanceof Backbone.View ){
                this.showProductoView.stopListening();
                this.showProductoView.undelegateEvents();
            }

            this.showProductoView = new app.ShowProductoView({ model: this.productoModel });
        },
        /**
        * show view edit producto
        */
        getProductosEdit: function (producto) {
            this.productoModel = new app.ProductoModel();
            this.productoModel.set({'id': producto}, {silent: true});

            if ( this.createProductoView instanceof Backbone.View ){
                this.createProductoView.stopListening();
                this.createProductoView.undelegateEvents();
            }

            this.createProductoView = new app.CreateProductoView({ model: this.productoModel });
            this.productoModel.fetch();
        },

        /**
        * show view main traslados
        */
        getTrasladosMain: function () {

            if ( this.mainTrasladosView instanceof Backbone.View ){
                this.mainTrasladosView.stopListening();
                this.mainTrasladosView.undelegateEvents();
            }

            this.mainTrasladosView = new app.MainTrasladosView( );
        },

        /**
        * show view create traslado
        */
        getTrasladosCreate: function () {
            this.trasladoModel = new app.TrasladoModel();

            if ( this.createTrasladoView instanceof Backbone.View ){
                this.createTrasladoView.stopListening();
                this.createTrasladoView.undelegateEvents();
            }

            this.createTrasladoView = new app.CreateTrasladoView({ model: this.trasladoModel });
            this.createTrasladoView.render();
        },

        /**
        * show view show traslado
        */
        getTrasladosShow: function (traslado) {
            this.trasladoModel = new app.TrasladoModel();
            this.trasladoModel.set({'id': traslado}, {'silent':true});

            if ( this.showTrasladoView instanceof Backbone.View ){
                this.showTrasladoView.stopListening();
                this.showTrasladoView.undelegateEvents();
            }

            this.showTrasladoView = new app.ShowTrasladoView({ model: this.trasladoModel });
        },

        /* ######################### Produccion #########################
        /**
        * show view main areas produccion
        */
        /**
        * show view edit tiempop
        */
        getTiempopMain: function () {
            if ( this.mainTiempopView instanceof Backbone.View ){
                this.mainTiempopView.stopListening();
                this.mainTiempopView.undelegateEvents();
            }

            this.mainTiempopView = new app.MainTiempopView( );
        },

        getAreaspMain: function () {

            if ( this.mainAreaspView instanceof Backbone.View ){
                this.mainAreaspView.stopListening();
                this.mainAreaspView.undelegateEvents();
            }

            this.mainAreaspView = new app.MainAreaspView( );
        },

        /**
        * show view create areas de produccion
        */
        getAreaspCreate: function () {
            this.areapModel = new app.AreapModel();

            if ( this.createAreapView instanceof Backbone.View ){
                this.createAreapView.stopListening();
                this.createAreapView.undelegateEvents();
            }

            this.createAreapView = new app.CreateAreapView({ model: this.areapModel });
            this.createAreapView.render();
        },

        /**
        * show view edit areas de produccion
        */
        getAreaspEdit: function (areap) {
            this.areapModel = new app.AreapModel();
            this.areapModel.set({'id': areap}, {'silent':true});

            if ( this.createAreapView instanceof Backbone.View ){
                this.createAreapView.stopListening();
                this.createAreapView.undelegateEvents();
            }

            this.createAreapView = new app.CreateAreapView({ model: this.areapModel });
            this.areapModel.fetch();
        },

        /**
        * show view create actividades de produccion de produccion
        */
        getActividadespMain: function () {

            if ( this.mainActividadespView instanceof Backbone.View ){
                this.mainActividadespView.stopListening();
                this.mainActividadespView.undelegateEvents();
            }

            this.mainActividadespView = new app.MainActividadespView( );
        },

        /**
        * show view create actividades de produccion de produccion
        */
        getActividadespCreate: function () {
            this.actividadpModel = new app.ActividadpModel();

            if ( this.createActividadpView instanceof Backbone.View ){
                this.createActividadpView.stopListening();
                this.createActividadpView.undelegateEvents();
            }

            this.createActividadpView = new app.CreateActividadpView({ model: this.actividadpModel });
            this.createActividadpView.render();
        },

        /**
        * show view edit actividades de produccion de produccion
        */
        getActividadespEdit: function ( actividadp ) {
            this.actividadpModel = new app.ActividadpModel();
            this.actividadpModel.set({'id': actividadp}, {'silent':true});

            if ( this.createActividadpView instanceof Backbone.View ){
                this.createActividadpView.stopListening();
                this.createActividadpView.undelegateEvents();
            }

            this.createActividadpView = new app.CreateActividadpView({ model: this.actividadpModel });
            this.actividadpModel.fetch();
        },

        /**
        * show view create subactividades de produccion de produccion
        */
        getSubActividadespMain: function () {

            if ( this.mainSubActividadespView instanceof Backbone.View ){
                this.mainSubActividadespView.stopListening();
                this.mainSubActividadespView.undelegateEvents();
            }

            this.mainSubActividadespView = new app.MainSubActividadespView( );
        },

        /**
        * show view create subactividades de produccion de produccion
        */
        getSubActividadespCreate: function () {
            this.subactividadpModel = new app.SubActividadpModel();

            if ( this.createSubActividadpView instanceof Backbone.View ){
                this.createSubActividadpView.stopListening();
                this.createSubActividadpView.undelegateEvents();
            }

            this.createSubActividadpView = new app.CreateSubActividadpView({ model: this.subactividadpModel });
            this.createSubActividadpView.render();
        },

        /**
        * show view edit actividades de produccion de produccion
        */
        getSubActividadespEdit: function ( subactividadp ) {
            this.subactividadpModel = new app.SubActividadpModel();
            this.subactividadpModel.set({'id': subactividadp}, {'silent':true});

            if ( this.createSubActividadpView instanceof Backbone.View ){
                this.createSubActividadpView.stopListening();
                this.createSubActividadpView.undelegateEvents();
            }

            this.createSubActividadpView = new app.CreateSubActividadpView({ model: this.subactividadpModel });
            this.subactividadpModel.fetch();
        },

        /**
        * show view main acabados produccion
        */
        getAcabadospMain: function () {

            if ( this.mainAcabadospView instanceof Backbone.View ){
                this.mainAcabadospView.stopListening();
                this.mainAcabadospView.undelegateEvents();
            }

            this.mainAcabadospView = new app.MainAcabadospView( );
        },

        /**
        * show view create acabados de produccion
        */
        getAcabadospCreate: function () {
            this.acabadopModel = new app.AcabadopModel();

            if ( this.createAcabadospView instanceof Backbone.View ){
                this.createAcabadospView.stopListening();
                this.createAcabadospView.undelegateEvents();
            }

            this.createAcabadospView = new app.CreateAcabadospView({ model: this.acabadopModel });
            this.createAcabadospView.render();
        },

        /**
        * show view edit areas de produccion
        */
        getAcabadospEdit: function (acabado) {
            this.acabadopModel = new app.AcabadopModel();
            this.acabadopModel.set({'id': acabado}, {'silent':true});

            if ( this.createAcabadospView instanceof Backbone.View ){
                this.createAcabadospView.stopListening();
                this.createAcabadospView.undelegateEvents();
            }

            this.createAcabadospView = new app.CreateAcabadospView({ model: this.acabadopModel });
            this.acabadopModel.fetch();
        },

        /**
        * show view main maquinas produccion
        */
        getMaquinaspMain: function () {

            if ( this.mainMaquinaspView instanceof Backbone.View ){
                this.mainMaquinaspView.stopListening();
                this.mainMaquinaspView.undelegateEvents();
            }

            this.mainMaquinaspView = new app.MainMaquinaspView( );
        },

        /**
        * show view create maquinas de produccion
        */
        getMaquinaspCreate: function () {
            this.maquinapModel = new app.MaquinapModel();

            if ( this.createMaquinapView instanceof Backbone.View ){
                this.createMaquinapView.stopListening();
                this.createMaquinapView.undelegateEvents();
            }

            this.createMaquinapView = new app.CreateMaquinapView({ model: this.maquinapModel });
            this.createMaquinapView.render();
        },

        /**
        * show view edit maquinas de produccion
        */
        getMaquinaspEdit: function (maquinap) {
            this.maquinapModel = new app.MaquinapModel();
            this.maquinapModel.set({'id': maquinap}, {'silent':true});

            if ( this.createMaquinapView instanceof Backbone.View ){
                this.createMaquinapView.stopListening();
                this.createMaquinapView.undelegateEvents();
            }

            this.createMaquinapView = new app.CreateMaquinapView({ model: this.maquinapModel });
            this.maquinapModel.fetch();
        },

        /**
        * show view main materiales produccion
        */
        getMaterialespMain: function () {

            if ( this.mainMaterialespView instanceof Backbone.View ){
                this.mainMaterialespView.stopListening();
                this.mainMaterialespView.undelegateEvents();
            }

            this.mainMaterialespView = new app.MainMaterialespView( );
        },

        /**
        * show view create materiales de produccion
        */
        getMaterialespCreate: function () {
            this.materialpModel = new app.MaterialpModel();

            if ( this.createMaterialpView instanceof Backbone.View ){
                this.createMaterialpView.stopListening();
                this.createMaterialpView.undelegateEvents();
            }

            this.createMaterialpView = new app.CreateMaterialpView({ model: this.materialpModel });
            this.createMaterialpView.render();
        },

        /**
        * show view edit materiales de produccion
        */
        getMaterialespEdit: function (materialp) {
            this.materialpModel = new app.MaterialpModel();
            this.materialpModel.set({'id': materialp}, {'silent':true});

            if ( this.createMaterialpView instanceof Backbone.View ){
                this.createMaterialpView.stopListening();
                this.createMaterialpView.undelegateEvents();
            }

            this.createMaterialpView = new app.CreateMaterialpView({ model: this.materialpModel });
            this.materialpModel.fetch();
        },

        /**
        * show view main tipos de material produccion
        */
        getTipoMaterialespMain: function () {

            if ( this.mainTipoMaterialespView instanceof Backbone.View ){
                this.mainTipoMaterialespView.stopListening();
                this.mainTipoMaterialespView.undelegateEvents();
            }

            this.mainTipoMaterialespView = new app.MainTipoMaterialespView( );
        },

        /**
        * show view create tipos de material de produccion
        */
        getTipoMaterialpCreate: function () {
            this.tipomaterialpModel = new app.TipoMaterialpModel();

            if ( this.createTipoMaterialpView instanceof Backbone.View ){
                this.createTipoMaterialpView.stopListening();
                this.createTipoMaterialpView.undelegateEvents();
            }

            this.createTipoMaterialpView = new app.CreateTipoMaterialpView({ model: this.tipomaterialpModel });
            this.createTipoMaterialpView.render();
        },

        /**
        * show view edit tipos de material de produccion
        */
        getTipoMaterialpEdit: function (tipomaterialp) {
            this.tipomaterialpModel = new app.TipoMaterialpModel();
            this.tipomaterialpModel.set({'id': tipomaterialp}, {'silent':true});

            if ( this.createTipoMaterialpView instanceof Backbone.View ){
                this.createTipoMaterialpView.stopListening();
                this.createTipoMaterialpView.undelegateEvents();
            }

            this.createTipoMaterialpView = new app.CreateTipoMaterialpView({ model: this.tipomaterialpModel });
            this.tipomaterialpModel.fetch();
        },

        /**
        * show view main tipos de producto produccion
        */
        getTipoProductopMain: function () {

            if ( this.mainTipoProductospView instanceof Backbone.View ){
                this.mainTipoProductospView.stopListening();
                this.mainTipoProductospView.undelegateEvents();
            }

            this.mainTipoProductospView = new app.MainTipoProductospView( );
        },

        /**
        * show view create tipos de producto de produccion
        */
        getTipoProductopCreate: function () {
            this.tipoproductopModel = new app.TipoProductopModel();

            if ( this.createTipoProductopView instanceof Backbone.View ){
                this.createTipoProductopView.stopListening();
                this.createTipoProductopView.undelegateEvents();
            }

            this.createTipoProductopView = new app.CreateTipoProductopView({ model: this.tipoproductopModel });
            this.createTipoProductopView.render();
        },

        /**
        * show view edit tipos de producto de produccion
        */
        getTipoProductopEdit: function ( tipoproductosp ) {
            this.tipoproductopModel = new app.TipoProductopModel();
            this.tipoproductopModel.set({'id': tipoproductosp }, {'silent':true});

            if ( this.createTipoProductopView instanceof Backbone.View ){
                this.createTipoProductopView.stopListening();
                this.createTipoProductopView.undelegateEvents();
            }

            this.createTipoProductopView = new app.CreateTipoProductopView({ model: this.tipoproductopModel });
            this.tipoproductopModel.fetch();
        },

        /**
        * show view main subtipos de producto produccion
        */
        getSubtipoProductopMain: function () {

            if ( this.mainSubtipoProductospView instanceof Backbone.View ){
                this.mainSubtipoProductospView.stopListening();
                this.mainSubtipoProductospView.undelegateEvents();
            }

            this.mainSubtipoProductospView = new app.MainSubtipoProductospView( );
        },

        /**
        * show view create subtipos de producto de produccion
        */
        getSubtipoProductopCreate: function () {
            this.subtipoproductopModel = new app.SubtipoProductopModel();

            if ( this.createSubtipoProductopView instanceof Backbone.View ){
                this.createSubtipoProductopView.stopListening();
                this.createSubtipoProductopView.undelegateEvents();
            }

            this.createSubtipoProductopView = new app.CreateSubtipoProductopView({ model: this.subtipoproductopModel });
            this.createSubtipoProductopView.render();
        },

        /**
        * show view edit subtipos de producto de produccion
        */
        getSubtipoProductopEdit: function ( subtipoproductosp ) {
            this.subtipoproductopModel = new app.SubtipoProductopModel();
            this.subtipoproductopModel.set({'id': subtipoproductosp }, {'silent':true});

            if ( this.createSubtipoProductopView instanceof Backbone.View ){
                this.createSubtipoProductopView.stopListening();
                this.createSubtipoProductopView.undelegateEvents();
            }

            this.createSubtipoProductopView = new app.CreateSubtipoProductopView({ model: this.subtipoproductopModel });
            this.subtipoproductopModel.fetch();
        },

        /**
        * show view main ordenes de produccion
        */
        getOrdenesMain: function () {
            if ( this.mainOrdenesView instanceof Backbone.View ){
                this.mainOrdenesView.stopListening();
                this.mainOrdenesView.undelegateEvents();
            }

            this.mainOrdenesView = new app.MainOrdenesView( );
        },

        /**
        * show view create ordenes de produccion
        */
        getOrdenesCreate: function () {
            this.ordenpModel = new app.OrdenpModel();

            if ( this.createOrdenpView instanceof Backbone.View ){
                this.createOrdenpView.stopListening();
                this.createOrdenpView.undelegateEvents();
            }

            this.createOrdenpView = new app.CreateOrdenpView({ model: this.ordenpModel });
            this.createOrdenpView.render();
        },

        /**
        * show view show orden
        */
        getOrdenesShow: function (orden) {
            this.ordenpModel = new app.OrdenpModel();
            this.ordenpModel.set({'id': orden}, {'silent':true});

            if ( this.showOrdenesView instanceof Backbone.View ){
                this.showOrdenesView.stopListening();
                this.showOrdenesView.undelegateEvents();
            }

            this.showOrdenesView = new app.ShowOrdenesView({ model: this.ordenpModel });
        },

        /**
        * show view edit ordenes
        */
        getOrdenesEdit: function (orden) {
            this.ordenpModel = new app.OrdenpModel();
            this.ordenpModel.set({'id': orden}, {'silent':true});

            if ( this.createOrdenpView instanceof Backbone.View ){
                this.createOrdenpView.stopListening();
                this.createOrdenpView.undelegateEvents();
            }

            if ( this.editOrdenpView instanceof Backbone.View ){
                this.editOrdenpView.stopListening();
                this.editOrdenpView.undelegateEvents();
            }

            this.editOrdenpView = new app.EditOrdenpView({ model: this.ordenpModel });
            this.ordenpModel.fetch();
        },

        /**
        * show view main productos produccion
        */
        getProductospMain: function () {

            if ( this.mainProductospView instanceof Backbone.View ){
                this.mainProductospView.stopListening();
                this.mainProductospView.undelegateEvents();
            }

            this.mainProductospView = new app.MainProductospView( );
        },

        /**
        * show view create productos en ordenes de produccion
        */
        getOrdenesProductoCreate: function (queryString) {
            var queries = this.parseQueryString(queryString);
            this.ordenp2Model = new app.Ordenp2Model();

            if ( this.createOrdenp2View instanceof Backbone.View ){
                this.createOrdenp2View.stopListening();
                this.createOrdenp2View.undelegateEvents();
            }

            this.createOrdenp2View = new app.CreateOrdenp2View({
                model: this.ordenp2Model,
                parameters: {
                    data : {
                        orden2_orden: queries.ordenp,
                        orden2_productop: queries.productop
                    }
                }
            });
            this.createOrdenp2View.render();
        },

        /**
        * show view edit ordenes
        */
        getOrdenesProductoEdit: function (producto) {
            this.ordenp2Model = new app.Ordenp2Model();
            this.ordenp2Model.set({'id': producto}, {'silent':true});

            if ( this.createOrdenp2View instanceof Backbone.View ){
                this.createOrdenp2View.stopListening();
                this.createOrdenp2View.undelegateEvents();
            }

            this.createOrdenp2View = new app.CreateOrdenp2View({ model: this.ordenp2Model });
            this.ordenp2Model.fetch();
        },

        /**
        * show view create productos produccion
        */
        getProductospCreate: function () {
            this.productopModel = new app.ProductopModel();

            if ( this.createProductopView instanceof Backbone.View ){
                this.createProductopView.stopListening();
                this.createProductopView.undelegateEvents();
            }

            this.createProductopView = new app.CreateProductopView({ model: this.productopModel });
            this.createProductopView.render();
        },

        /**
        * show view show tercero
        */
        getProductospShow: function (producto) {
            this.productopModel = new app.ProductopModel();
            this.productopModel.set({'id': producto}, {silent: true});

            if ( this.showProductopView instanceof Backbone.View ){
                this.showProductopView.stopListening();
                this.showProductopView.undelegateEvents();
            }

            this.showProductopView = new app.ShowProductopView({ model: this.productopModel });
        },

        /**
        * show view edit productos produccion
        */
        getProductospEdit: function (producto) {
            this.productopModel = new app.ProductopModel();
            this.productopModel.set({'id': producto}, {silent: true});

            if ( this.createProductopView instanceof Backbone.View ){
                this.createProductopView.stopListening();
                this.createProductopView.undelegateEvents();
            }

            if ( this.editProductopView instanceof Backbone.View ){
                this.editProductopView.stopListening();
                this.editProductopView.undelegateEvents();
            }

            this.editProductopView = new app.EditProductopView({ model: this.productopModel });
            this.productopModel.fetch();
        },

        /**
        * show view main cotizacion produccion
        */
        getCotizacionesMain: function () {

            if ( this.mainCotizacionesView instanceof Backbone.View ){
                this.mainCotizacionesView.stopListening();
                this.mainCotizacionesView.undelegateEvents();
            }

            this.mainCotizacionesView = new app.MainCotizacionesView( );
        },

        /**
        * show view create cotizacion produccion
        */
        getCotizacionesCreate: function () {
            this.cotizacionModel = new app.CotizacionModel();

            if ( this.createCotizacionView instanceof Backbone.View ){
                this.createCotizacionView.stopListening();
                this.createCotizacionView.undelegateEvents();
            }

            this.createCotizacionView = new app.CreateCotizacionView({ model: this.cotizacionModel });
            this.createCotizacionView.render();
        },

        /**
        * show view show tercero
        */
        getCotizacionesShow: function (cotizacion) {
            this.cotizacionModel = new app.CotizacionModel();
            this.cotizacionModel.set({'id': cotizacion}, {silent: true});

            if ( this.showCotizacionView instanceof Backbone.View ){
                this.showCotizacionView.stopListening();
                this.showCotizacionView.undelegateEvents();
            }

            this.showCotizacionView = new app.ShowCotizacionView({ model: this.cotizacionModel });
        },

        /**
        * show view edit cotizacion produccion
        */
        getCotizacionesEdit: function (cotizacion) {
            this.cotizacionModel = new app.CotizacionModel();
            this.cotizacionModel.set({'id': cotizacion}, {'silent':true});

            if ( this.editCotizacionView instanceof Backbone.View ){
                this.editCotizacionView.stopListening();
                this.editCotizacionView.undelegateEvents();
            }

            if ( this.createCotizacionView instanceof Backbone.View ){
                this.createCotizacionView.stopListening();
                this.createCotizacionView.undelegateEvents();
            }

            this.editCotizacionView = new app.EditCotizacionView({ model: this.cotizacionModel });
            this.cotizacionModel.fetch();
        },

        /**
        * show view create productos en cotizaciones
        */
        getCotizacionesProductoCreate: function (queryString) {
            var queries = this.parseQueryString(queryString);
            this.cotizacion2Model = new app.Cotizacion2Model();

            if ( this.createCotizacion2View instanceof Backbone.View ){
                this.createCotizacion2View.stopListening();
                this.createCotizacion2View.undelegateEvents();
            }

            this.createCotizacion2View = new app.CreateCotizacion2View({
                model: this.cotizacion2Model,
                parameters: {
                    data : {
                        cotizacion2_cotizacion: queries.cotizacion,
                        cotizacion2_productop: queries.productop
                    }
                }
            });
            this.createCotizacion2View.render();
        },

        /**
        * show view edit cotizaciones
        */
        getCotizacionesProductoEdit: function (producto) {
            this.cotizacion2Model = new app.Cotizacion2Model();
            this.cotizacion2Model.set({'id': producto}, {'silent':true});

            if ( this.createCotizacion2View instanceof Backbone.View ){
                this.createCotizacion2View.stopListening();
                this.createCotizacion2View.undelegateEvents();
            }

            this.createCotizacion2View = new app.CreateCotizacion2View({ model: this.cotizacion2Model });
            this.cotizacion2Model.fetch();
        },

        /**
        * Cartera
        */

        // Facturas
        getFacturasMain: function () {

            if ( this.mainFacturaView instanceof Backbone.View ){
                this.mainFacturaView.stopListening();
                this.mainFacturaView.undelegateEvents();
            }

            this.mainFacturaView = new app.MainFacturasView( );
        },

        getFacturaCreate: function () {
            this.facturaModel = new app.FacturaModel();
            if ( this.createFacturaView instanceof Backbone.View ){
                this.createFacturaView.stopListening();
                this.createFacturaView.undelegateEvents();
            }

            this.createFacturaView = new app.CreateFacturaView({ model: this.facturaModel });
            this.createFacturaView.render();
        },

        getFacturaShow: function(facturas){
            this.facturaModel = new app.FacturaModel();
            this.facturaModel.set({'id': facturas}, {'silent':true});
            if ( this.showFacturasView instanceof Backbone.View ){
                this.showFacturasView.stopListening();
                this.showFacturasView.undelegateEvents();
            }

            this.showFacturasView = new app.ShowFacturaView({ model: this.facturaModel });
        },

        /**
        * Treasury
        */
        getFacturaspMain: function() {
            if ( this.mainFacturaspView instanceof Backbone.View ){
                this.mainFacturaspView.stopListening();
                this.mainFacturaspView.undelegateEvents();
            }

            this.mainFacturaspView = new app.MainFacturaspView();
        },

        getFacturaspShow: function(facturap){
            this.facturapModel = new app.FacturapModel();
            this.facturapModel.set({'id': facturap}, {'silent':true});

            if( this.showFacturapView instanceof Backbone.View ){
                this.showFacturapView.stopListening();
                this.showFacturapView.undelegateEvents();
            }

            this.showFacturapView = new app.ShowFacturapView({ model: this.facturapModel });
        },
    }) );

})(jQuery, this, this.document);

/**
* Init Class
*/

/*global*/
var app = app || {};

(function ($, window, document, undefined) {

    var InitComponent = function() {

        //Init Attributes
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    String.prototype.replaceAll = function(search, replace)
    {
        if(!replace)
            return this;
        return this.replace(new RegExp('[' + search + ']', 'g'), replace);
    };

    InitComponent.prototype = {

        /**
        * Constructor or Initialize Method
        */
        initialize: function () {
            //Initialize
            this.initApp();
            this.initICheck();
            this.initAlertify();
            this.initInputMask();
            this.initSelect2();
            this.initToUpper();
            this.initSpinner();
            this.initDatePicker();
            this.initTimePicker();
        },

        /**
        * Init Backbone Application
        */
        initApp: function () {
            window.app.AppRouter.start();
        },

        /**
        * Init icheck
        */
        initICheck: function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });
        },

        /**
        * Init alertify
        */
        initAlertify: function () {
            alertify.logPosition("bottom right");
        },

        /**
        * Init inputMask
        */
        initInputMask: function () {

            $("[data-mask]").inputmask();

            $("[data-currency]").inputmask({
                radixPoint: ",",
                alias: 'currency',
                removeMaskOnSubmit: true,
                unmaskAsNumber: true,
                min: 0
            });

            $("[data-currency-negative]").inputmask({
                radixPoint: ",",
                alias: 'currency',
                prefix: '',
                removeMaskOnSubmit: true,
                unmaskAsNumber: true,
            });
        },

        /**
        * Init select2
        */
        initSelect2: function () {
            var _this = this,
                config = {
                  '.select2-default' : { language: 'es', placeholder: 'Seleccione', allowClear: false },
                  '.select2-default-clear'  : { language: 'es', placeholder: 'Seleccione', allowClear: true },
                  '.choice-select-autocomplete': {
                    language: "es",
                    placeholder:'Seleccione una opción',
                    ajax: {
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        escapeMarkup: function (markup) { return markup; },
                        cache: true,
                        minimumInputLength: 1
                    }
                  }
                };

            // Instance selects to choice plugin
            for (var selector in config){
                $(selector).each(function(index, el) {
                    var $el = $(el);

                    if( $el.data('select2') == undefined ){
                        $el.select2(config[selector]);

                        // set default option
                        if(selector == '.choice-select-autocomplete') {

                            var initialId = $el.data('initial-value');
                            var $option = null;

                            if(initialId) {
                                var ajaxOptions = $el.data('select2').dataAdapter.ajaxOptions;

                                $option = $('<option selected>Cargando...</option>').val(initialId);
                                $el.append($option).trigger('change');

                                $.get( ajaxOptions.url, {id:initialId}, function(data) {
                                    $option.text(data[0].text).val(data[0].id);
                                    $option.removeData();
                                    $el.trigger('change');
                                });
                            }
                        }
                    }
                });
            }
        },

        /**
        * Init toUpper
        */
        initToUpper: function () {
           $('.input-toupper').change(function(){
               $(this).val( $(this).val().toUpperCase() );
           });

           $('.input-lower').change(function(){
                var dato = $(this).val( $(this).val().toLowerCase() );
                var reg = /[^a-z0-9]/i;
                var valor = '';
                for(var i=0; i <= dato.val().length-1; i++){
                    if( !reg.test(dato.val().charAt(i)) ){
                        dato.val().replace(reg,'');
                        valor += dato.val().charAt(i);
                    }
                }
                $(this).val( valor );
           });
        },

        /**
        * Init initSpinner
        */
        initSpinner: function () {
            $('.spinner-percentage').spinner({
                step: 0.1,
                start: 0,
                min: 0,
                max: 100,
                numberFormat: "n",
                stop: function( event, ui ) {
                    if(!_.isNull(this.value) && !_.isUndefined(this.value) && !_.isEmpty(this.value)) {
                        if(!$.isNumeric( this.value ) || this.value > 100 || this.value < 0){
                            $(this).spinner( 'value', 0 );
                        }
                    }
               }
            });
        },

        /**
        * Init initValidator
        */
        initValidator: function () {

            $('form[data-toggle="validator"]').each(function () {
                var $form = $(this)
                $.fn.validator.call($form, $form.data())
            })
        },

        /**
        * Init Datepicker
        */
        initDatePicker: function () {

            $('.datepicker').datepicker({
                autoclose: true,
                language: 'es',
                format: 'yyyy-mm-dd'
            });
        },

        /**
        * Init Timepicker
        */
        initTimePicker: function () {

            $(".timepicker").timepicker({
                showInputs: false,
                showMeridian: false
            });
        }
    };

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();
    });

})(jQuery, this, this.document);

//# sourceMappingURL=app.min.js.map
