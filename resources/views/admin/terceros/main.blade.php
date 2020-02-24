@extends('layout.layout')

@section('title') Terceros @stop

@section('content')
    @yield('module')

    <script type="text/template" id="add-tercero-tpl">
        <section class="content-header">
            <h1>
                Terceros <small>Administración de terceros</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
                <li><a href="{{ route('terceros.index') }}">Terceros</a></li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('terceros.show', { terceros: id}) ) %>"><%- tercero_nit %></a></li>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success spinner-main">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-tercero" data-toggle="validator">
                		<div class="row">
                			<div class="form-group col-md-3">
                				<label for="tercero_nit" class="control-label">Documento</label>
                				<div class="row">
                					<div class="col-md-9">
                						<input id="tercero_nit" value="<%- tercero_nit %>" placeholder="Nit" class="form-control input-sm change-nit-koi-component" name="tercero_nit" type="text" required data-field="tercero_digito">
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
                				<select name="tercero_persona" id="tercero_persona" class="form-control" required>
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
                			<div class="form-group col-md-3">
                				<label for="tercero_nombre1" class="control-label">1er. Nombre</label>
                				<input id="tercero_nombre1" value="<%- tercero_nombre1 %>" placeholder="1er. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre1" type="text">
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_nombre2" class="control-label">2do. Nombre</label>
                				<input id="tercero_nombre2" value="<%- tercero_nombre2 %>" placeholder="2do. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre2" type="text">
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_apellido1" class="control-label">1er. Apellido</label>
                				<input id="tercero_apellido1" value="<%- tercero_apellido1 %>" placeholder="1er. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido1" type="text">
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_apellido2" class="control-label">2do. Apellido</label>
                				<input id="tercero_apellido2" value="<%- tercero_apellido2 %>" placeholder="2do. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido2" type="text">
                			</div>
                		</div>
                		<div class="row">
                			<div class="form-group col-md-12">
                				<label for="tercero_razonsocial" class="control-label">Razón Social, Comercial o Establecimiento</label>
                				<input id="tercero_razonsocial" value="<%- tercero_razonsocial %>" placeholder="Razón Social, Comercial o Establecimiento" class="form-control input-sm input-toupper" name="tercero_razonsocial" type="text">
                			</div>
                		</div>
                		<div class="row">
                			<div class="form-group col-md-6">
                				<label for="tercero_nombre_comercial" class="control-label">Nombre Comercial</label>
                				<input id="tercero_nombre_comercial" value="<%- tercero_nombre_comercial %>" placeholder="Nombre Comercial" class="form-control input-sm input-toupper" name="tercero_nombre_comercial" type="text">
                			</div>
                            <div class="form-group col-md-6">
                                <label for="tercero_sigla" class="control-label">Sigla</label>
                                <input id="tercero_sigla" value="<%- tercero_sigla %>" placeholder="Sigla" class="form-control input-sm input-toupper" name="tercero_sigla" type="text" maxlength="200">
                            </div>
                		</div>
                		<div class="row">
                			<div class="form-group col-md-6">
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
                			<div class="form-group col-md-6">
                				<label for="tercero_municipio" class="control-label">Municipio</label>
                				<select name="tercero_municipio" id="tercero_municipio" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('search.municipios'))%>" data-placeholder="Seleccione" placeholder="Seleccione" data-initial-value="<%- tercero_municipio %>">
                				</select>
                			</div>
            			</div>
                        <div class="row">
                			<div class="form-group col-md-6">
                				<label for="tercero_email" class="control-label">Email</label>
                				<input id="tercero_email" value="<%- tercero_email %>" placeholder="Email" class="form-control input-sm" name="tercero_email" type="email">
                			    <div class="help-block with-errors"></div>
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_email_factura1" class="control-label">Email Factura 1</label>
                				<input id="tercero_email_factura1" value="<%- tercero_email_factura1 %>" placeholder="Email Factura 1" class="form-control input-sm" name="tercero_email_factura1" type="email">
                			    <div class="help-block with-errors"></div>
                			</div>
                			<div class="form-group col-md-3">
                                <label for="tercero_email_factura2" class="control-label">Email Factura 2</label>
                				<input id="tercero_email_factura2" value="<%- tercero_email_factura2 %>" placeholder="Email Factura 2" class="form-control input-sm" name="tercero_email_factura2" type="email">
                			    <div class="help-block with-errors"></div>
                			</div>
                	    </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="tercero_codigopostal" class="control-label">Código postal</label>
                                <input id="tercero_codigopostal" value="<%- tercero_codigopostal %>" placeholder="Código postal" class="form-control input-sm" name="tercero_codigopostal" type="text" maxlength="6">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tercero_formapago" class="control-label">Forma de pago <small>(dias)</small></label>
                                <input id="tercero_formapago" value="<%- tercero_formapago %>" placeholder="Forma de pago" class="form-control input-sm input-toupper" name="tercero_formapago" type="text" maxlength="30" required>
                            </div>
                        </div>
                	    <div class="row">
                	    	<div class="form-group col-md-3">
                				<label for="tercero_telefono1" class="control-label">Teléfono</label>
                				<div class="input-group">
                					<div class="input-group-addon">
                						<i class="fa fa-phone"></i>
                					</div>
                					<input id="tercero_telefono1" value="<%- tercero_telefono1 %>" class="form-control input-sm" name="tercero_telefono1" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
                				</div>
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
                				<div class="input-group">
                					<div class="input-group-addon">
                						<i class="fa fa-phone"></i>
                					</div>
                					<input id="tercero_telefono2" value="<%- tercero_telefono2 %>" class="form-control input-sm" name="tercero_telefono2" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
                				</div>
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_fax" class="control-label">Fax</label>
                				<div class="input-group">
                					<div class="input-group-addon">
                						<i class="fa fa-fax"></i>
                					</div>
                					<input id="tercero_fax" value="<%- tercero_fax %>" class="form-control input-sm" name="tercero_fax" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
                				</div>
                			</div>
                			<div class="form-group col-md-3">
                				<label for="tercero_celular" class="control-label">Celular</label>
                				<div class="input-group">
                					<div class="input-group-addon">
                						<i class="fa fa-mobile"></i>
                					</div>
                					<input id="tercero_celular" value="<%- tercero_celular %>" class="form-control input-sm" name="tercero_celular" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
                				</div>
                			</div>
                		</div>
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-4 col-md-3">
                                <label for="tercero_vendedor" class="control-label">Vendedor</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tercero_vendedor">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="tercero_vendedor" placeholder="Documento" class="form-control tercero-koi-component" name="tercero_vendedor" type="text" maxlength="15" data-name="tercero_vendedor_nombre" data-vendedor="true" value="<%- vendedor_nit %>">
                                </div>
                            </div>
                            <div class="col-sm-6"><br>
                                <input id="tercero_vendedor_nombre" name="tercero_vendedor_nombre" placeholder="Nombre vendedor" class="form-control input-sm" type="text" maxlength="15" value="<%- vendedor_nombre %>" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tercero_comision" class="control-label">Comisión Vendedor</label>
                                <input type="number" id="tercero_comision" name="tercero_comision" value="<%- tercero_comision %>" placeholder="Vendedor" class="form-control input-sm" min="0" step="0.1" max="100">
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
                            <div class="col-md-offset-4 col-md-2 col-sm-6 col-xs-6">
                                <a href="<%- window.Misc.urlFull( (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') ? Route.route('terceros.show', { terceros: id}) : Route.route('terceros.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                            </div>
                        </div>
	               </form>
                </div>
            </div>

            <div class="box box-solid spinner-main">
    			<div class="nav-tabs-custom tab-success">
    				<ul class="nav nav-tabs">
    					<li class="active"><a href="#tab_contabilidad" data-toggle="tab">Contabilidad</a></li>
    					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
    						<li><a id="wrapper-empleados" href="#tab_empleados" data-toggle="tab" class="<%- parseInt(tercero_empleado) || parseInt(tercero_interno) ? '' : 'hide' %>">Empleado</a></li>
    						<li><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
                            @ability ('archivos' | 'terceros')
                                <li><a href="#tab_archivos" data-toggle="tab">Archivos</a></li>
                            @endability
    					<% } %>
    				</ul>

    				<div class="tab-content">
    					{{-- Tab contabilidad --}}
    					<div class="tab-pane active" id="tab_contabilidad">
    						<form method="POST" accept-charset="UTF-8" id="form-accounting" data-toggle="validator">
    				    	    <div class="row">
    						    	<div class="form-group col-md-10">
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
    									<label class="checkbox-inline" for="tercero_cliente">
    										<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente" <%- parseInt(tercero_cliente) ? 'checked': ''%>> Cliente
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_acreedor">
    										<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor" <%- parseInt(tercero_acreedor) ? 'checked': ''%>> Acreedor
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_proveedor">
    										<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor" <%- parseInt(tercero_proveedor) ? 'checked': ''%>> Proveedor
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_autoretenedor_ica">
    										<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica" <%- parseInt(tercero_autoretenedor_ica) ? 'checked': ''%>> Autorretenedor ICA
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_responsable_iva">
    										<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva" <%- parseInt(tercero_responsable_iva) ? 'checked': ''%>> Responsable de IVA
    									</label>
    								</div>
                                    <div class="form-group col-md-2">
                                        <label class="checkbox-inline" for="tercero_empleado">
                                            <input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado" <%- parseInt(tercero_empleado) ? 'checked': ''%> class="change_employee"> Empleado
                                        </label>
                                    </div>
    						    </div>

    						    <div class="row">
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_interno">
    										<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno" <%- parseInt(tercero_interno) ? 'checked': ''%> class="change_employee"> Interno
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_extranjero">
    										<input type="checkbox" id="tercero_extranjero" name="tercero_extranjero" value="tercero_extranjero" <%- parseInt(tercero_extranjero) ? 'checked': ''%>> Extranjero
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_afiliado">
    										<input type="checkbox" id="tercero_afiliado" name="tercero_afiliado" value="tercero_afiliado" <%- parseInt(tercero_afiliado) ? 'checked': ''%>> Afiliado
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_autoretenedor_cree">
    										<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree" <%- parseInt(tercero_autoretenedor_cree) ? 'checked': ''%>> Autorretenedor CREE
    									</label>
    								</div>
                                    <div class="form-group col-md-2">
                                        <label class="checkbox-inline" for="tercero_socio">
                                            <input type="checkbox" id="tercero_socio" name="tercero_socio" value="tercero_socio" <%- parseInt(tercero_socio) ? 'checked': ''%>> Socio
                                        </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="checkbox-inline" for="tercero_mandatario">
                                            <input type="checkbox" id="tercero_mandatario" name="tercero_mandatario" value="tercero_mandatario" <%- parseInt(tercero_mandatario) ? 'checked': ''%>> Mandatario
                                        </label>
                                    </div>
    						    </div>

    							<div class="row">
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_gran_contribuyente">
    										<input type="checkbox" id="tercero_gran_contribuyente" name="tercero_gran_contribuyente" value="tercero_gran_contribuyente" <%- parseInt(tercero_gran_contribuyente) ? 'checked': ''%>> Gran contribuyente
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_autoretenedor_renta">
    										<input type="checkbox" id="tercero_autoretenedor_renta" name="tercero_autoretenedor_renta" value="tercero_autoretenedor_renta" <%- parseInt(tercero_autoretenedor_renta) ? 'checked': ''%>> Autorretenedor renta
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_vendedor_estado">
    										<input type="checkbox" id="tercero_vendedor_estado" name="tercero_vendedor_estado" value="tercero_vendedor_estado" <%- parseInt(tercero_vendedor_estado) ? 'checked': ''%>> Vendedor
    									</label>
    								</div>
    								<div class="form-group col-md-2">
    									<label class="checkbox-inline" for="tercero_otro">
    										<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro" <%- parseInt(tercero_otro) ? 'checked': ''%>> Otro
    									</label>
    								</div>
    								<div class="form-group col-md-4">
    									<input id="tercero_cual" value="<%- tercero_cual %>" placeholder="¿Cual?" class="form-control input-sm" name="tercero_cual" type="text" maxlength="15">
    								</div>
    						    </div>
    						</form>
    					</div>

    					<% if( !_.isUndefined(tercero_nit) && !_.isNull(tercero_nit) && tercero_nit != ''){ %>
    						{{-- Tab empleados --}}
    						<div class="tab-pane" id="tab_empleados">
    							<form method="POST" accept-charset="UTF-8" id="form-employee" data-toggle="validator">
    								<div class="row">
    							    	<div class="form-group col-md-2">
    								    	<label class="checkbox-inline" for="tercero_activo">
    											<input type="checkbox" id="tercero_activo" name="tercero_activo" value="tercero_activo" <%- parseInt(tercero_activo) ? 'checked': ''%>> Activo
    										</label>
    									</div>
    							    	<div class="form-group col-md-2">
    								    	<label class="checkbox-inline" for="tercero_tecnico">
    											<input type="checkbox" id="tercero_tecnico" name="tercero_tecnico" value="tercero_tecnico" <%- parseInt(tercero_tecnico) ? 'checked': ''%>> Técnico
    										</label>
    									</div>
    								</div>
    								<div class="row">
    									<div class="form-group col-md-2">
    								    	<label class="checkbox-inline" for="tercero_coordinador">
    											<input type="checkbox" id="tercero_coordinador" name="tercero_coordinador" value="tercero_coordinador" <%- parseInt(tercero_coordinador) ? 'checked': ''%>> Coordinador
    										</label>
    									</div>

    	                               	<div id="wrapper-coordinador" class="form-group col-md-6 <%- parseInt(tercero_tecnico) ? '' : 'hide' %>">
    										<label for="tercero_coordinador_por" class="control-label">Coordinado por</label>
    										<select name="tercero_coordinador_por" id="tercero_coordinador_por" class="form-control select2-default">
    		                                    @foreach (App\Models\Base\Tercero::getTechnicalAdministrators() as $key => $value)
    		                                        <option value="{{ $key }}" <%- tercero_coordinador_por == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
    		                                    @endforeach
    		                                </select>
    			                        </div>
    								</div>
    							</form>

    							<br />
    							<div class="row">
    								<div class="form-group col-md-6">
    					            	<div class="box box-success" id="wrapper-password">
    										<div class="box-header with-border">
    											<h3 class="box-title">Datos de acceso</h3>
    										</div>
    										<div class="box-body">
    											<form method="POST" accept-charset="UTF-8" id="form-changed-password" data-toggle="validator">
    												<div class="row">
    													<div class="form-group col-md-12">
    														<label for="username" class="control-label">Cuenta de usuario</label>
    														<input type="text" name="username" id="username" class="form-control input-lower" value="<%- username %>" minlength="4" maxlength="20" required>
    													</div>
    												</div>

    												<div class="row">
    													<div class="form-group col-md-6">
    													<label for="password" class="control-label">Contraseña</label>
    														<input type="password" name="password" id="password" class="form-control" minlength="6" maxlength="15">
    														<div class="help-block">Minimo de 6 caracteres</div>
    													</div>

    													<div class="form-group col-md-6">
    													<label for="password_confirmation" class="control-label">Verificar contraseña</label>
    														<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" data-match="#password" data-match-error="Oops, no coinciden la contraseña" minlength="6" maxlength="15">
    														<div class="help-block with-errors"></div>
    													</div>
    												</div>

    												<div class="row">
    													<div class="col-md-12 text-center">
    														<button type="submit" class="btn btn-success change-pass">Cambiar</button>
    													</div>
    												</div>
    											</form>
    										</div>
    									</div>
    								</div>
    						    	<div class="form-group col-md-6">
    									<div class="box box-success" id="wrapper-roles">
    										<div class="box-header with-border">
    											<h3 class="box-title">Roles de usuario</h3>
    										</div>
    							            <div class="box-body">
    						                    <form method="POST" accept-charset="UTF-8" id="form-item-roles" data-toggle="validator">
    						                        <div class="row">
    						                        	<label for="role_id" class="control-label col-sm-1 col-md-offset-1 hidden-xs">Rol</label>
    						                            <div class="form-group col-md-7 col-xs-9">
    						                                <select name="role_id" id="role_id" class="form-control select2-default" required>
    						                                    @foreach (App\Models\Base\Rol::getRoles() as $key => $value)
    						                                        <option value="{{ $key }}">{{ $value }}</option>
    						                                    @endforeach
    						                                </select>
    						                            </div>
    						                            <div class="form-group col-md-2 col-xs-3">
    						                                <button type="submit" class="btn btn-success btn-sm btn-block">
    						                                    <i class="fa fa-plus"></i>
    						                                </button>
    						                            </div>
    						                        </div>
    						                    </form>
    						                    <!-- table table-bordered table-striped -->
    						                    <div class="table-responsive no-padding">
    						                        <table id="browse-roles-list" class="table table-bordered" cellspacing="0">
    						                            <thead>
    						                                <tr>
    						                                    <th width="5%"></th>
    						                                    <th width="95%">Nombre</th>
    						                                </tr>
    						                            </thead>
    						                            <tbody>
    						                                {{-- Render content roles --}}
    						                            </tbody>
    						                        </table>
    						                    </div>
    						                </div>
    						            </div>
    					            </div>
    							</div>
    						</div>

    						{{-- Tab contactos --}}
    						<div class="tab-pane" id="tab_contactos">
    						    <div class="row">
    								<div class="col-md-offset-5 col-md-2 col-sm-offset-2 col-sm-8 col-xs-12">
    									<button type="button" class="btn btn-primary btn-block btn-sm btn-add-tcontacto">
    										<i class="fa fa-user-plus"></i>  Nuevo contacto
    									</button>
    								</div>
    							</div>
    							<br />

    							<div class="box box-success">
    								<div class="box-body table-responsive no-padding">
    									<table id="browse-contact-list" class="table table-bordered" cellspacing="0" width="100%">
    							            <thead>
    								            <tr>
    								                <th>Nombre</th>
    								                <th>Dirección</th>
    								                <th>Teléfono</th>
    								                <th>Celular</th>
    								            </tr>
    							           </thead>
    							           <tbody>
    											{{-- Render contact list --}}
    							           </tbody>
    									</table>
    								</div>
    							</div>
    						</div>
                            @ability ('archivos' | 'terceros')
        						<div class="tab-pane" id="tab_archivos">
                                    <div class="fine-uploader"></div>
        						</div>
                            @endability
    					<% } %>
    				</div>
    			</div>
    		</div>
        </section>
    </script>

    <script type="text/template" id="add-detalle-factura-cartera-tpl">
    	<td><%- factura1_numero %></td>
        <td><%- puntoventa_prefijo %></td>
        <td><%- factura4_cuota %></td>
        <td><%- factura1_fecha %></td>
    	<td><%- factura4_vencimiento %></td>
    	<td><%- days %></td>
        <td class="text-right"><%- window.Misc.currency(factura4_saldo) %></td>
    </script>

    <script type="text/template" id="qq-template-tercero">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            @ability ('archivos' | 'terceros')
                <div class="buttons">
                    <div class="qq-upload-button-selector qq-upload-button">
                        <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                    </div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>{{ trans('app.files.process') }}</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            @endability
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <a class="preview-link" target="_blank">
                        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    </a>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">{{ trans('app.files.retry') }}</button>
                    @ability ('archivos' | 'terceros')
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
                    @endability
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>
            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Si</button>
                </div>
            </dialog>
            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-ok-button-selector">{{ trans('app.continue') }}</button>
                </div>
            </dialog>
        </div>
    </script>
@stop
