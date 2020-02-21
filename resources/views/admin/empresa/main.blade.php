@extends('layout.layout')

@section('title') Empresa @stop

@section('content')
    <section class="content-header">
		<h1>
			Empresa <small>Administración de empresa</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Empresa</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="empresa-create">
            @ability ('editar' | 'empresa')
	 	        {!! Form::open(['id' => 'form-create-empresa', 'data-toggle' => 'validator']) !!}
            @endability

			<div class="box-body" id="render-form-empresa">
				{{-- Render form empresa --}}
			</div>

            @ability ('editar' | 'empresa')
        			<div class="box-header with-border">
        	        	<div class="row">
        					<div class="col-md-2 col-md-offset-5 col-sm-12 col-xs-6 text-right">
        						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
        					</div>
        				</div>
			         </div>
                {!! Form::close() !!}
            @endability
		</div>
	</section>

	<script type="text/template" id="add-company-tpl">
		<div class="row">
			<div class="form-group col-md-3">
				<label for="tercero_nit" class="control-label">Documento</label>
				<div class="row">
					<div class="col-md-9">
						<input id="tercero_nit" value="<%- tercero_nit %>" placeholder="Nit" class="form-control input-sm" name="tercero_nit" type="text" required>
					</div>
					<div class="col-md-3">
						<input id="tercero_digito" value="<%- tercero_digito %>" class="form-control input-sm" name="tercero_digito" type="text" readonly required>
					</div>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_tipo" class="control-label">Tipo</label>
				<select name="tercero_tipo" id="tercero_tipo" class="form-control" required>
					<option value="" selected>Seleccione</option>
					@foreach (config('koi.terceros.tipo') as $key => $value)
						<option value="{{ $key }}" <%- tercero_tipo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_persona" class="control-label">Persona</label>
				<select name="tercero_persona" id="tercero_persona" class="form-control" required readonly>
					<option value="" selected>Seleccione</option>
					@foreach (config('koi.terceros.persona') as $key => $value)
						<option value="{{ $key }}" <%- tercero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_regimen" class="control-label">Regimen</label>
				<select name="tercero_regimen" id="tercero_regimen" class="form-control" required>
					<option value="" selected>Seleccione</option>
					@foreach (config('koi.terceros.regimen') as $key => $value)
						<option value="{{ $key }}" <%- tercero_regimen == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<label for="tercero_razonsocial" class="control-label">Razón Social, Comercial o Establecimiento</label>
				<input id="tercero_razonsocial" value="<%- tercero_razonsocial %>" placeholder="Razón Social, Comercial o Establecimiento" class="form-control input-sm input-toupper" name="tercero_razonsocial" type="text">
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label for="tercero_direccion" class="control-label">Dirección</label> <small id="tercero_nomenclatura"><%- tercero_direccion_nomenclatura %></small>
	      		<div class="input-group input-group-sm">
	      		<input type="hidden" id="tercero_direccion_nomenclatura" name="tercero_direccion_nomenclatura" value="<%- tercero_direccion_nomenclatura %>">
					<input id="tercero_direccion" value="<%- tercero_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tercero_direccion" type="text" data-nm-name="tercero_nomenclatura" data-nm-value="tercero_direccion_nomenclatura" required>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
							<i class="fa fa-map-signs"></i>
						</button>
					</span>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_municipio" class="control-label">Municipio</label>
				<select name="tercero_municipio" id="tercero_municipio" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('search.municipios'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_municipio %>">
				</select>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_email" class="control-label">Email</label>
				<input id="tercero_email" value="<%- tercero_email %>" placeholder="Email" class="form-control input-sm" name="tercero_email" type="email">
			    <div class="help-block with-errors"></div>
			</div>

			<div class="form-group col-md-3">
				<label for="empresa_paginacion" class="control-label">Paginación</label>
				<input id="empresa_paginacion" value="<%- empresa_paginacion %>" placeholder="Rango" class="form-control input-sm" name="empresa_paginacion" type="number" min="1" max="1000" step="1">
			    <div class="help-block with-errors"></div>
			</div>
	    </div>

	    <div class="row">
	    	<div class="form-group col-md-3">
				<label for="tercero_telefono1" class="control-label">Teléfono</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-phone"></i>
					</div>
					<input id="tercero_telefono1" value="<%- tercero_telefono1 %>" class="form-control input-sm" name="tercero_telefono1" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-phone"></i>
					</div>
					<input id="tercero_telefono2" value="<%- tercero_telefono2 %>" class="form-control input-sm" name="tercero_telefono2" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_fax" class="control-label">Fax</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-fax"></i>
					</div>
					<input id="tercero_fax" value="<%- tercero_fax %>" class="form-control input-sm" name="tercero_fax" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
				</div>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_celular" class="control-label">Celular</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-mobile"></i>
					</div>
					<input id="tercero_celular" value="<%- tercero_celular %>" class="form-control input-sm" name="tercero_celular" type="text" data-inputmask="'mask': '999 999-99-99'" data-mask>
				</div>
			</div>
		</div>

	    <div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_representante" class="control-label">Representante Legal</label>
				<input id="tercero_representante" value="<%- tercero_representante %>" placeholder="Representante Legal" class="form-control input-sm input-toupper" name="tercero_representante" type="text" maxlength="200">
			</div>
			<div class="form-group col-md-3">
	    		<label for="tercero_cc_representante" class="control-label">Cédula</label>
	    		<input id="tercero_cc_representante" value="<%- tercero_cc_representante %>" placeholder="Cédula" class="form-control input-sm" name="tercero_cc_representante" type="text" maxlength="15">
	    	</div>
			<div class="form-group col-md-3">
	    		<label for="tercero_formapago" class="control-label">Forma de pago</label>
	    		<input id="tercero_formapago" value="<%- tercero_formapago %>" placeholder="Forma de pago" class="form-control input-sm" name="tercero_formapago"  type="text" maxlength="30">
	    	</div>
		</div>

	    <div class="row">
	    	<div class="form-group col-md-12">
				<div class="nav-tabs-custom tab-success">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
					</ul>
					<div class="tab-content">

						{{-- Tab contabilidad --}}
						<div class="tab-pane active" id="tab_contabilidad">
		    	    	    <div class="row">
		    	    	    	<div class="form-group col-md-2">
						    		<label for="empresa_niif" class="control-label">Grupo Niif</label>
						    		<select name="empresa_niif" id="empresa_niif" class="form-control" required>
										<option value="">Seleccione</option>
										@foreach (config('koi.terceros.niif') as $key => $value)
											<option value="{{ $key }}" <%- empresa_niif == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
										@endforeach
									</select>
						    	</div>
						    	<div class="form-group col-md-8">
						    		<label for="tercero_actividad" class="control-label">Actividad Económica</label>
									<select name="tercero_actividad" id="tercero_actividad" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('search.actividades'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_actividad %>">
									</select>
						    	</div>
						    	<div class="form-group col-md-2">
						    		<label for="tercero_retecree" class="control-label">% Cree</label>
						    		<div id="tercero_retecree"><%- actividad_tarifa %></div>
						    	</div>
						    </div>

				    	    <div class="row">
								<div class="form-group col-md-2">
						    		<label for="empresa_iva" class="control-label">Iva</label>
						    		<select name="empresa_iva" id="empresa_iva" class="form-control" required>
                                        @foreach (config('koi.contabilidad.iva') as $key => $value)
                                            <option value="{{ $key }}" <%- empresa_iva == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                        @endforeach
                                    </select>
						    	</div>
								<div class="form-group col-md-2">
						    		<label for="empresa_base_retefuente_factura" class="control-label">Retefuente</label>
                                    <input name="empresa_base_retefuente_factura" id="empresa_base_retefuente_factura" class="form-control input-sm" value="<%- empresa_base_retefuente_factura %>" data-currency></input>
						    	</div>
								<div class="form-group col-md-2">
						    		<label for="empresa_porcentaje_retefuente_factura" class="control-label">Retefuente %</label>
                                	<input type="text" id="empresa_porcentaje_retefuente_factura" name="empresa_porcentaje_retefuente_factura" value="<%- empresa_porcentaje_retefuente_factura %>" class="form-control input-sm spinner-percentage" maxlength="4" required>
						    	</div>
								<div class="form-group col-md-2">
						    		<label for="empresa_base_reteiva_factura" class="control-label">ReteIva</label>
                                    <input name="empresa_base_reteiva_factura" id="empresa_base_reteiva_factura" class="form-control input-sm" value="<%- empresa_base_reteiva_factura %> "data-currency></input>
						    	</div>
                                <div class="form-group col-md-2">
                                    <label for="empresa_porcentaje_reteiva_factura" class="control-label">ReteIva %</label>
                                    <input type="text" id="empresa_porcentaje_reteiva_factura" name="empresa_porcentaje_reteiva_factura" value="<%- empresa_porcentaje_reteiva_factura %>" class="form-control input-sm spinner-percentage" maxlength="4" required>
                                </div>
								<div class="form-group col-md-2">
						    		<label for="empresa_base_ica_compras" class="control-label">ReteIca</label>
                                    <input name="empresa_base_ica_compras" id="empresa_base_ica_compras" class="form-control input-sm" value="<%- empresa_base_ica_compras %>" data-currency></input>
						    	</div>
                            </div>
                            <div class="row">
						    	<div class="form-group col-md-10 col-sm-12 col-xs-12">
									<label class="control-label"></label>
									<div class="row">
										<label class="checkbox-inline" for="tercero_responsable_iva">
											<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva" <%- parseInt(tercero_responsable_iva) ? 'checked': ''%>> Responsable de IVA
										</label>

										<label class="checkbox-inline" for="tercero_autoretenedor_cree">
											<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree" <%- parseInt(tercero_autoretenedor_cree) ? 'checked': ''%>> Autorretenedor CREE
										</label>

										<label class="checkbox-inline" for="tercero_gran_contribuyente">
											<input type="checkbox" id="tercero_gran_contribuyente" name="tercero_gran_contribuyente" value="tercero_gran_contribuyente" <%- parseInt(tercero_gran_contribuyente) ? 'checked': ''%>> Gran contribuyente
										</label>

										<label class="checkbox-inline" for="tercero_autoretenedor_renta">
											<input type="checkbox" id="tercero_autoretenedor_renta" name="tercero_autoretenedor_renta" value="tercero_autoretenedor_renta" <%- parseInt(tercero_autoretenedor_renta) ? 'checked': ''%>> Autorretenedor renta
										</label>

										<label class="checkbox-inline" for="tercero_autoretenedor_ica">
											<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica" <%- parseInt(tercero_autoretenedor_ica) ? 'checked': ''%>> Autorretenedor ICA
										</label>

										<label class="checkbox-inline" for="empresa_round">
											<input type="checkbox" id="empresa_round" name="empresa_round" value="empresa_round" <%- parseInt(empresa_round) ? 'checked': ''%>> Redondear
										</label>
									</div>
								</div>
						    </div>

						    <div class="row">
						    	<div class="form-group col-md-6">
						    		<label for="empresa_nm_contador" class="control-label">Contador</label>
									<input id="empresa_nm_contador" value="<%- empresa_nm_contador %>" placeholder="Contador" class="form-control input-sm input-toupper" name="empresa_nm_contador" type="text" maxlength="200">
						    	</div>
						    	<div class="form-group col-md-3">
						    		<label for="empresa_cc_contador" class="control-label">Cédula</label>
						    		<input id="empresa_cc_contador" value="<%- empresa_cc_contador %>" placeholder="Cédula" class="form-control input-sm" name="empresa_cc_contador" type="text" maxlength="15">
						    	</div>
						    	<div class="form-group col-md-3">
						    		<label for="empresa_tj_contador" class="control-label">Tarjeta de Profesional</label>
						    		<input id="empresa_tj_contador" value="<%- empresa_tj_contador %>" placeholder="Tarjeta de Profesional" class="form-control input-sm" name="empresa_tj_contador" type="text" maxlength="15">
						    	</div>
						    </div>

						    <div class="row">
						    	<div class="form-group col-md-6">
						    		<label for="empresa_nm_revisor" class="control-label">Revisor Fiscal</label>
									<input id="empresa_nm_revisor" value="<%- empresa_nm_revisor %>" placeholder="Revisor Fiscal" class="form-control input-sm input-toupper" name="empresa_nm_revisor" type="text" maxlength="200">
						    	</div>
						    	<div class="form-group col-md-3">
						    		<label for="empresa_cc_revisor" class="control-label">Cédula</label>
						    		<input id="empresa_cc_revisor" value="<%- empresa_cc_revisor %>" placeholder="Cédula" class="form-control input-sm" name="empresa_cc_revisor" type="text" maxlength="15">
						    	</div>
						    	<div class="form-group col-md-3">
						    		<label for="empresa_tj_revisor" class="control-label">Tarjeta de Profesional</label>
						    		<input id="empresa_tj_revisor" value="<%- empresa_tj_revisor %>" placeholder="Tarjeta de Profesional" class="form-control input-sm" name="empresa_tj_revisor" type="text" maxlength="15">
						    	</div>
						    </div>
						</div>

					</div>
				</div>
			</div>
	    </div>
	</script>
@stop
