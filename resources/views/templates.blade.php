{{-- templates --}}
<script type="text/template" id="tercero-name-tpl">
	<div class="row">
		<% if(tercero_persona == 'J'){ %>
			<div class="form-group col-md-12">
				<label for="tercero_razonsocial" class="control-label">Razón Social o Comercial</label>
				<input id="tercero_razonsocial" value="<%- tercero_razonsocial %>" placeholder="Raz&oacute;n Social o Comercial" class="form-control input-sm input-toupper" name="tercero_razonsocial" type="text" required>		
			</div>
		<% }else{ %>
			<div class="form-group col-md-3">
				<label for="tercero_nombre1" class="control-label">1er. Nombre</label>
				<input id="tercero_nombre1" value="<%- tercero_nombre1 %>" placeholder="1er. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre1" type="text" required>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_nombre2" class="control-label">2do. Nombre</label>
				<input id="tercero_nombre2" value="<%- tercero_nombre2 %>" placeholder="2do. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre2" type="text">
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_apellido1" class="control-label">1er. Apellido</label>
				<input id="tercero_apellido1" value="<%- tercero_apellido1 %>" placeholder="1er. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido1" type="text" required>
			</div>

			<div class="form-group col-md-3">
				<label for="tercero_apellido2" class="control-label">2do. Apellido</label>
				<input id="tercero_apellido2" value="<%- tercero_apellido2 %>" placeholder="2do. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido2" type="text">
			</div>
		<% } %>
	</div>
</script>

<script type="text/template" id="add-tercero-tpl">
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
				@foreach( config('koi.terceros.tipo') as $key => $value)
					<option value="{{ $key }}" <%- tercero_tipo == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_persona" class="control-label">Persona</label>
			<select name="tercero_persona" id="tercero_persona" class="form-control" required>
				<option value="" selected>Seleccione</option>
				@foreach( config('koi.terceros.persona') as $key => $value)
					<option value="{{ $key }}" <%- tercero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
		
		<div class="form-group col-md-3">
			<label for="tercero_regimen" class="control-label">Regimen</label>
			<select name="tercero_regimen" id="tercero_regimen" class="form-control" required>
				<option value="" selected>Seleccione</option>
				@foreach( config('koi.terceros.regimen') as $key => $value)
					<option value="{{ $key }}" <%- tercero_regimen == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
	</div>

	{{-- Render name --}}
	<div id="content-render-name"></div>

	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_direccion" class="control-label">Dirección</label>
      		<div class="input-group input-group-sm">
				<input id="tercero_direccion" value="<%- tercero_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tercero_direccion" type="text" required>		
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
						<i class="fa fa-map-signs"></i>
					</button>
				</span>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_municipio" class="control-label">Municipio</label>
			<select name="tercero_municipio" id="tercero_municipio" class="form-control select2-default" required>
				@foreach( App\Models\Base\Municipio::getMunicipios() as $key => $value)
					<option value="{{ $key }}" <%- tercero_municipio == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_email" class="control-label">Email</label>
			<input id="tercero_email" value="<%- tercero_email %>" placeholder="Email" class="form-control input-sm" name="tercero_email" type="email">
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
	</div>

    <div class="row">
    	<div class="form-group col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						<li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
					<% } %>
				</ul>
				<div class="tab-content">
									
					{{-- Tab contabilidad --}}
					<div class="tab-pane active" id="tab_contabilidad">
	    	    	    <div class="row">
					    	<div class="form-group col-md-10">
					    		<label for="tercero_actividad" class="control-label">Actividad Económica</label>
					    		<select name="tercero_actividad" id="tercero_actividad" class="form-control select2-default" required>
									@foreach( App\Models\Base\Actividad::getActividades() as $key => $value)
										<option value="{{ $key }}" <%- tercero_actividad == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
									@endforeach
								</select>
					    	</div>
					    	<div class="form-group col-md-2">
					    		<label for="tercero_retecree" class="control-label">% Cree</label>
					    		<div id="tercero_retecree"><%- actividad_tarifa %></div>
					    	</div>
					    </div>

					    <div class="row">
					    	<div class="form-group col-md-2">
						    	<label class="checkbox-inline" for="tercero_activo">
									<input type="checkbox" id="tercero_activo" name="tercero_activo" value="tercero_activo" <%- tercero_activo ? 'checked': ''%>> Activo
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_cliente">
									<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente" <%- tercero_socio ? 'checked': ''%>> Cliente
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_acreedor">
									<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor" <%- tercero_acreedor ? 'checked': ''%>> Acreedor
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_interno">
									<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno" <%- tercero_interno ? 'checked': ''%>> Interno
								</label>
							</div>

							<div class="form-group col-md-3">
								<label class="checkbox-inline" for="tercero_responsable_iva">
									<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva" <%- tercero_responsable_iva ? 'checked': ''%>> Responsable de IVA
								</label>
							</div>
					    </div>

					    <div class="row">
					    	<div class="form-group col-md-2">
						    	<label class="checkbox-inline" for="tercero_empleado">
									<input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado" <%- tercero_empleado ? 'checked': ''%>> Empleado
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_proveedor">
									<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor" <%- tercero_proveedor ? 'checked': ''%>> Proveedor
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_extranjero">
									<input type="checkbox" id="tercero_extranjero" name="tercero_extranjero" value="tercero_extranjero" <%- tercero_extranjero ? 'checked': ''%>> Extranjero
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_afiliado">
									<input type="checkbox" id="tercero_afiliado" name="tercero_afiliado" value="tercero_afiliado" <%- tercero_afiliado ? 'checked': ''%>> Afiliado
								</label>
							</div>

							<div class="form-group col-md-3">
								<label class="checkbox-inline" for="tercero_autoretenedor_cree">
									<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree" <%- tercero_autoretenedor_cree ? 'checked': ''%>> Autorretenedor CREE
								</label>
							</div>
					    </div>
						
						<div class="row">
							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_socio">
									<input type="checkbox" id="tercero_socio" name="tercero_socio" value="tercero_socio" <%- tercero_socio ? 'checked': ''%>> Socio
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_mandatario">
									<input type="checkbox" id="tercero_mandatario" name="tercero_mandatario" value="tercero_mandatario" <%- tercero_mandatario ? 'checked': ''%>> Mandatario
								</label>
							</div>

							<div class="form-group col-md-2">
								<label class="checkbox-inline" for="tercero_otro">
									<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro" <%- tercero_otro ? 'checked': ''%>> Otro
								</label>
							</div>

							<div class="form-group col-md-2">
								<input id="tercero_cual" value="<%- tercero_cual %>" placeholder="¿Cual?" class="form-control input-sm" name="tercero_cual" type="text" maxlength="15">
							</div>
					    </div>
					</div>
					
					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
						{{-- Tab contactos --}}
						<div class="tab-pane" id="tab_contactos">
							<div class="box">
								<div class="box-body table-responsive no-padding">
									<table id="browse-contact-list" class="table table-hover">	
										{{-- Render contact list --}}						
									</table>
								</div>
							</div>
						</div>
					<% } %>
				</div>
			</div>
		</div>
    </div>
</script>

<script type="text/template" id="contact-item-list-tpl">
	<td><%- tcontacto_nombre %></td>
	<td><%- tcontacto_direccion %></td>
	<td><%- tcontacto_telefono %></td>
	<td><%- tcontacto_celular %></td>
	<td><%- tcontacto_email %></td>
	<td><%- tcontacto_cargo %></td>
</script>

<script type="text/template" id="add-centrocosto-tpl">
    <div class="row">
		<div class="form-group col-md-2">
			<label for="centrocosto_codigo" class="control-label">Código</label>			
			<input type="text" id="centrocosto_codigo" name="centrocosto_codigo" value="<%- centrocosto_codigo %>" placeholder="Código" class="form-control input-sm input-toupper" maxlength="4" required>
		</div>
    	<div class="form-group col-md-3">
			<label for="centrocosto_centro" class="control-label">Centro</label>			
			<input type="text" id="centrocosto_centro" name="centrocosto_centro" value="<%- centrocosto_centro %>" placeholder="Centro" class="form-control input-sm input-toupper" maxlength="20" required>
		</div>
		<div class="form-group col-md-7">
			<label for="centrocosto_nombre" class="control-label">Nombre</label>
			<input type="text" id="centrocosto_nombre" name="centrocosto_nombre" value="<%- centrocosto_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>    
		</div>
    </div>
	
	<div class="row">
		<div class="form-group col-md-12">
			<label for="centrocosto_descripcion1" class="control-label">Descripcion 1</label>
			<input type="text" id="centrocosto_descripcion1" name="centrocosto_descripcion1" value="<%- centrocosto_descripcion1 %>" placeholder="Descripcion 1" class="form-control input-sm input-toupper" maxlength="200">    
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-12">
			<label for="centrocosto_descripcion2" class="control-label">Descripcion 2</label>
			<input type="text" id="centrocosto_descripcion2" name="centrocosto_descripcion2" value="<%- centrocosto_descripcion2 %>" placeholder="Descripcion 2" class="form-control input-sm input-toupper" maxlength="200">    
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-2 col-xs-4 col-sm-4">
			<label for="centrocosto_estructura" class="control-label">Estructura</label>
			<select name="centrocosto_estructura" id="centrocosto_estructura" class="form-control" required>
				<option value="N" <%- centrocosto_estructura == 'N' ? 'selected': ''%>>No</option>
				<option value="S" <%- centrocosto_estructura == 'S' ? 'selected': ''%>>Si</option>
			</select>
		</div>
		<div class="form-group col-md-2 col-xs-4 col-sm-4">
			<br><label class="checkbox-inline" for="centrocosto_orden">
				<input type="checkbox" id="centrocosto_orden" name="centrocosto_orden" value="centrocosto_orden" <%- centrocosto_orden ? 'checked': ''%>> Orden
			</label>    
		</div>		
		<div class="form-group col-md-2 col-xs-4 col-sm-4">
			<br><label class="checkbox-inline" for="centrocosto_activo">
				<input type="checkbox" id="centrocosto_activo" name="centrocosto_activo" value="centrocosto_activo" <%- centrocosto_activo ? 'checked': ''%>> Activo
			</label>    
		</div>
    </div>
</script>

<script type="text/template" id="add-plancuentas-tpl">
    <div class="row">
		<div class="form-group col-md-3">
			<label for="plancuentas_cuenta" class="control-label">Cuenta</label>
			<div class="row">
				<div class="col-md-9">
					<input type="text" id="plancuentas_cuenta" name="plancuentas_cuenta" value="<%- plancuentas_cuenta %>" placeholder="Cuenta" class="form-control input-sm" maxlength="15" required>
				</div>
				<div class="col-md-3">
					<input type="text" id="plancuentas_nivel" name="plancuentas_nivel" value="<%- plancuentas_nivel %>" class="form-control input-sm" maxlength="1" required readonly>				
				</div>
			</div>
		</div>

		<div class="form-group col-md-7">
			<label for="plancuentas_nombre" class="control-label">Nombre</label>
			<input type="text" id="plancuentas_nombre" name="plancuentas_nombre" value="<%- plancuentas_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="200" required>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-5 col-xs-10">
			<label for="plancuentas_centro" class="control-label">Centro de costo</label>
			<select name="plancuentas_centro" id="plancuentas_centro" class="form-control select2-default-clear">
				@foreach( App\Models\Accounting\CentroCosto::getCentrosCosto() as $key => $value)
					<option value="{{ $key }}" <%- plancuentas_centro == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-1 col-xs-2 text-right">
			<div>&nbsp;</div>
			<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="centrocosto" data-field="plancuentas_centro">
				<i class="fa fa-plus"></i>
			</button>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<label class="control-label">Naturaleza</label>
			<div class="row">
				<label class="radio-inline" for="plancuentas_naturaleza_debito">
					<input type="radio" id="plancuentas_naturaleza_debito" name="plancuentas_naturaleza" value="D" checked> Débito
				</label>

				<label class="radio-inline" for="plancuentas_naturaleza_credito">
					<input type="radio" id="plancuentas_naturaleza_credito" name="plancuentas_naturaleza" value="C"> Crédito
				</label>
			</div>	
		</div>
	</div>

    <div class="row">
		<div class="form-group col-md-3 col-sm-12 col-xs-12">
			<label for="plancuentas_tercero">¿Requiere tercero?</label>
			<div class="row">
				<label class="radio-inline" for="plancuentas_tercero_no">
					<input type="radio" id="plancuentas_tercero_no" name="plancuentas_tercero" value="false" checked> Si
				</label>

				<label class="radio-inline" for="plancuentas_tercero_si">
					<input type="radio" id="plancuentas_tercero_si" name="plancuentas_tercero" value="true"> No
				</label>
			</div>
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<label class="control-label">Tipo</label>
			<div class="row">
				@foreach(config('koi.contabilidad.plancuentas.tipo') as $key => $value)
					<label class="radio-inline" for="plancuentas_naturaleza_{{ $key }}">
						<input type="radio" id="plancuentas_naturaleza_{{ $key }}" name="plancuentas_tipo" value="{{ $key }}" checked> {{ $value }}
					</label>					
				@endforeach
			</div>	
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-2">
			<label for="plancuentas_tasa" class="control-label">Tasa</label>
			<input type="text" id="plancuentas_tasa" name="plancuentas_tasa" value="<%- plancuentas_tasa ? plancuentas_tasa : '0' %>" placeholder="Tasa" class="form-control input-sm" required>
		</div>
    </div>
</script>

<script type="text/template" id="add-asiento2-item-tpl">
	<td><%- asiento2_cuenta %></td>
    <td><%- plancuentas_nombre %></td>
    <td><a href="<%- window.Misc.urlFull( Route.route('terceros.show', {terceros: asiento2_beneficiario}) ) %>" target="_blank"><%- asiento2_beneficiario_nit %></a></td>
    <td><%- centrocosto_nombre %></td>
    <td class="text-right"><%- asiento2_base ? asiento2_base : 0 %></td>
    <td class="text-right"><%- asiento2_debito ? asiento2_debito : 0 %></td>
    <td class="text-right"><%- asiento2_credito ? asiento2_credito: 0 %></td>
    <td><%- asiento2_detalle %></td>
</script>