@extends('layout.layout')

@section('title') Asientos contables NIF @stop

@section('content')
	@yield('module')

    {{-- Templates --}}
    <script type="text/template" id="add-asienton-tpl">
	    <section class="content-header">
			<h1>
				Asientos contables NIF<small>Administración asientos contables NIF</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
					<li><a href="{{ route('asientosnif.index') }}">Asientos contables NIF</a></li>
		    	<% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
					<li><a href="<%- window.Misc.urlFull( Route.route('asientosnif.show', { asientosnif: id}) ) %>"><%- id %></a></li>
					<li class="active">Editar</li>
				<% }else{ %>
					<li class="active">Nuevo</li>
				<% } %>
			</ol>
	    </section>

	    <section class="content">
		    <div class="box box-success" id="spinner-main">
		    	<div class="box-body" id="render-form-asientosn">
					<form method="POST" accept-charset="UTF-8" id="form-asientosn" data-toggle="validator">
						<div class="row">
							<label for="asienton1_ano" class="col-sm-1 control-label">Fecha</label>
							<div class="form-group col-sm-2">
								<input id="asienton1_ano" value="<%- asienton1_ano %>" placeholder="Año" class="form-control input-sm input-toupper" name="asienton1_ano" type="number" maxlength="4" data-minlength="4" required>
							</div>

							<div class="form-group col-sm-2">
								<select name="asienton1_mes" id="asienton1_mes" class="form-control" required>
									@foreach( config('koi.meses') as $key => $value)
										<option value="{{ $key }}" <%- asienton1_mes == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group col-sm-1">
								<select name="asienton1_dia" id="asienton1_dia" class="form-control" required>
									@for($i = 1; $i <= 31; $i++)
										<option value="{{ $i }}" <%- asienton1_dia == '{{ $i }}' ? 'selected': ''%>>{{ $i }}</option>
									@endfor
								</select>
							</div>

							<% if(edit) { %>
								<div class="col-md-1 col-sm-2 col-xs-2 text-right pull-right">
									<a href="<%- window.Misc.urlFull( Route.route('asientosnif.exportar', { asientosnif: id}) ) %>" class="btn btn-danger btn-sm btn-block">
										<i class="fa fa-file-pdf-o"></i>
									</a>
								</div>
							<% } %>
						</div>

						<div class="row">
							<label for="asienton1_folder" class="col-sm-1 control-label">Folder</label>
							<div class="form-group col-sm-3">
								<select name="asienton1_folder" id="asienton1_folder" class="form-control select2-default select-filter-document-koi-component" data-wrapper="spinner-main" data-documents="asienton1_documento" required>
									<option value="" selected>Seleccione</option>
									@foreach( App\Models\Accounting\Folder::getFolders() as $key => $value)
										<option value="{{ $key }}" <%- asienton1_folder == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
									@endforeach
								</select>
							</div>

							<label for="asienton1_documento" class="col-sm-1 control-label">Documento</label>
							<div class="form-group col-sm-3">
								<select name="asienton1_documento" id="asienton1_documento" class="form-control select2-default" required>
									<option value="" selected>Seleccione</option>
									@foreach( App\Models\Accounting\Documento::getDocuments() as $key => $value)
										<option value="{{ $key }}" <%- asienton1_documento == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
									@endforeach
								</select>
							</div>

							<label for="asienton1_numero" class="col-sm-1 control-label">Número</label>
							<div class="form-group col-sm-2">
								<input id="asienton1_numero" name="asienton1_numero" value="<%- asienton1_numero %>" placeholder="Número" class="form-control input-sm input-toupper" type="number" required>
							</div>

							<% if(asienton1_preguardado) { %>
								<div class="col-md-1 text-right pull-right">
									<span class="label label-warning">PRE-GUARDADO</span>
								</div>
							<% } %>
			            </div>

						<div class="row">
							<label for="asienton1_beneficiario" class="col-sm-1 control-label">Beneficiario</label>
							<div class="form-group col-sm-3">
					      		<div class="input-group input-group-sm">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="asienton1_beneficiario">
											<i class="fa fa-user"></i>
										</button>
									</span>
									<input id="asienton1_beneficiario" placeholder="Beneficiario" class="form-control tercero-koi-component" name="asienton1_beneficiario" type="text" maxlength="15" data-wrapper="spinner-main" data-name="asienton1_beneficiario_nombre" value="<%- tercero_nit %>" required>
								</div>
							</div>
							<div class="col-sm-5">
								<input id="asienton1_beneficiario_nombre" name="asienton1_beneficiario_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tercero" data-field="asienton1_beneficiario">
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>

						<div class="row">
							<label for="asienton1_detalle" class="col-sm-1 control-label">Detalle</label>
							<div class="form-group col-sm-10">
								<textarea id="asienton1_detalle" name="asienton1_detalle" class="form-control" rows="2" placeholder="Detalle"><%- asienton1_detalle %></textarea>
							</div>
			            </div>

    					<div class="box-footer with-border">
				        	<div class="row">
								<div class="col-md-2 <%- (edit) ? 'col-md-offset-4' : 'col-md-offset-5' %> col-sm-6 col-xs-6 text-left">
									<a href="<%- window.Misc.urlFull( edit ? Route.route('asientosnif.show', { asientosnif: id}) : Route.route('asientosnif.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
								</div>

								<% if(edit) { %>
									<div class="col-md-2 col-sm-6 col-xs-6 text-right">
										<button type="button" class="btn btn-primary btn-sm btn-block submit-asienton">{{ trans('app.save') }}</button>
									</div>
								<% } %>
							</div>
						</div><br>
					<% if(edit) { %> </form> <% } %>

					<!-- Detalle -->
					<div class="box box-success">
						<% if(edit) { %> <form method="POST" accept-charset="UTF-8" id="form-item-asienton" data-toggle="validator"> <% } %>
							<div class="box-body">
								<div class="row">
									<div class="form-group col-sm-2">
							      		<div class="input-group input-group-sm">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="plancuentasn_cuenta">
													<i class="fa fa-tasks"></i>
												</button>
											</span>
											<input id="plancuentasn_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="plancuentasn_cuenta" type="text" maxlength="15" data-wrapper="spinner-main" data-name="plancuentasn_nombre" data-base="asienton2_base" data-valor="asienton2_valor" data-centro="asienton2_centro" data-tasa="asienton2_tasa" required>
										</div>
									</div>
									<div class="col-sm-3">
										<input id="plancuentasn_nombre" name="plancuentasn_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled required>
									</div>

									<div class="form-group col-sm-6">
										<select name="asienton2_centro" id="asienton2_centro" class="form-control select2-default-clear"  data-placeholder="Seleccione centro de costo">
											@foreach( App\Models\Accounting\CentroCosto::getCentrosCosto() as $key => $value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-sm-2">
							      		<div class="input-group input-group-sm">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tercero_nit">
													<i class="fa fa-user"></i>
												</button>
											</span>
											<input id="tercero_nit" placeholder="Beneficiario" class="form-control tercero-koi-component" name="tercero_nit" type="text" maxlength="15" data-wrapper="spinner-main" data-name="tercero_nombre">
										</div>
									</div>
									<div class="col-sm-3">
										<input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
									</div>
									<div class="col-sm-1">
										<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tercero" data-field="tercero_nit">
											<i class="fa fa-plus"></i>
										</button>
									</div>

									<div class="form-group col-sm-2">
										<label class="radio-inline without-padding" for="asienton2_naturaleza_debito">
											<input type="radio" id="asienton2_naturaleza_debito" name="asienton2_naturaleza" value="D" checked> Débito
										</label>

										<label class="radio-inline without-padding" for="asienton2_naturaleza_credito">
											<input type="radio" id="asienton2_naturaleza_credito" name="asienton2_naturaleza" value="C"> Crédito
										</label>
									</div>

									<div class="form-group col-sm-1 text-right">
										<label for="asienton2_base" class="control-label">Base</label>
									</div>

									<div class="form-group col-sm-2">
										<input id="asienton2_base" name="asienton2_base" placeholder="Base" class="form-control input-sm" data-currency readonly="readonly" type="text">
										<input id="asienton2_tasa" name="asienton2_tasa" type="hidden">
									</div>
								</div>

								<div class="row">
									<div class="form-group col-sm-8">
										<input id="asienton2_detalle" name="asienton2_detalle" class="form-control input-sm" placeholder="Detalle" type="text">
									</div>
									<div class="form-group col-sm-1 text-right">
										<label for="asienton2_valor" class="control-label">Valor</label>
									</div>
									<div class="form-group col-sm-2">
										<input id="asienton2_valor" name="asienton2_valor" placeholder="Valor" class="form-control input-sm" data-currency type="text" required>
									</div>
									<div class="form-group col-sm-1">
										<button type="submit" class="btn btn-success btn-sm btn-block">
											<i class="fa fa-plus"></i>
										</button>
									</div>
					            </div>
							</div>
						</form>

						<!-- table table-bordered table-striped -->
						<div class="box-body table-responsive no-padding">
							<table id="browse-detalle-asienton-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
					            <tr>
					                <th></th>
					                <th>Cuenta</th>
					                <th>Nombre</th>
					                <th>Beneficiario</th>
					                <th>Centro Costo</th>
					                <th>Base</th>
					                <th>Debito</th>
					                <th>Credito</th>
					                <th></th>
					            </tr>
								<tfoot>
									<tr>
										<td colspan="5"></td>
										<th class="text-left">Total</th>
										<td class="text-right" id="total-debitos">0</td>
										<td class="text-right" id="total-creditos">0</td>
										<td></td>
									</tr>
									<tr>
										<td colspan="5"></td>
										<th class="text-left">Diferencia</th>
										<td colspan="2" class="text-right">
											<small class="label pull-right bg-red" id="total-diferencia">0</small>
										</td>
										<td></td>
									</tr>
								</tfoot>
						    </table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</script>

	<script type="text/template" id="add-asienton2-item-tpl">
		<% if(edit) { %>
		<td class="text-center">
			<a class="btn btn-default btn-xs item-asienton2-remove" data-resource="<%- id %>">
				<span><i class="fa fa-times"></i></span>
			</a>
		</td>
		<% } %>
		<td><%- plancuentasn_cuenta %></td>
	    <td><%- plancuentasn_nombre %></td>
	    <td>
	    	<a href="<%- window.Misc.urlFull( Route.route('terceros.show', {terceros: asienton2_beneficiario}) ) %>" title="<%- tercero_nombre %>" target="_blank">
	    		<%- tercero_nit %>
	    	</a>
	    </td>
	    <td>
	    	<% if( !_.isUndefined(asienton2_centro) && !_.isNull(asienton2_centro) && asienton2_centro != '') { %>
		    	<a href="<%- window.Misc.urlFull( Route.route('centroscosto.show', {centroscosto: asienton2_centro}) ) %>" title="<%- centrocosto_nombre %>" target="_blank">
		    		<%- centrocosto_codigo %>
		    	</a>
	    	<% } %>
	    </td>
	    <td class="text-right"><%- window.Misc.currency(asienton2_base ? asienton2_base : 0) %></td>
	    <td class="text-right"><%- window.Misc.currency(asienton2_debito ? asienton2_debito : 0) %></td>
	    <td class="text-right"><%- window.Misc.currency(asienton2_credito ? asienton2_credito: 0) %></td>
	    <td class="text-center">
			<a class="btn btn-default btn-xs item-asiento2-show-info" data-resource="<%- id %>">
				<span><i class="fa fa-info-circle"></i></span>
			</a>
		</td>
	</script>

	<script type="text/template" id="searchordenp-asiento-tpl">
		<div class="row">
			<div class="col-md-12 text-center">
				<label class="control-label">
					Seleccione orden de producción para asociar al <%- asienton2_naturaleza == 'D' ? 'Débito' : 'Crédito' %>.
				</label>
			</div>
		</div>

		<div class="row">
			<label for="asienton1_beneficiario" class="col-sm-offset-1 col-sm-1 control-label">Orden</label>
			<div class="form-group col-sm-3">
	      		<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="asienton2_orden">
							<i class="fa fa-building-o"></i>
						</button>
					</span>
					<input id="asienton2_orden" placeholder="Orden" class="form-control ordenp-koi-component" name="asienton2_orden" type="text" maxlength="15" data-factura="false" data-wrapper="modal-asiento-wrapper-ordenp" data-name="asienton2_orden_beneficiario" required>
				</div>
			</div>
			<div class="col-sm-6">
				<input id="asienton2_orden_beneficiario" name="asienton2_orden_beneficiario" placeholder="Tercero" class="form-control input-sm" type="text" readonly required>
			</div>
		</div>
	</script>

	<script type="text/template" id="rfacturap-asiento-tpl">
		<div class="row">
			<div class="form-group col-md-12 text-center">
				<strong>(<%- tercero_nit %> - <%- tercero_nombre %>)</strong>
			</div>
		</div>

	    <div class="row">
			<div class="form-group col-md-9">
				<label for="facturap1_factura" class="control-label">
					Ingrese el numero de factura para realizar el <%- asienton2_naturaleza == 'D' ? 'Débito' : 'Crédito' %>.
				</label>
				<input type="text" id="facturap1_factura" name="facturap1_factura" placeholder="Factura" class="form-control input-sm" maxlength="200" required>
			</div>
			<div class="form-group col-md-3">
				<label class="control-label">Valor</label>
				<div><%- window.Misc.currency( asienton2_valor ) %></div>
			</div>
		</div>
		<div id="content-invoice"></div>
	</script>

	<script type="text/template" id="rcartera-asiento-tpl">
		<div class="row">
			<div class="form-group col-md-12 text-center">
				<strong>(<%- tercero_nit %> - <%- tercero_nombre %>)</strong>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				<label class="control-label">
					Seleccione factura del cliente <%- asienton2_naturaleza == 'D' ? 'Débito' : 'Crédito' %>.
				</label>
			</div>
		</div>

		<div class="row"><br>
			<label for="factura_koi" class="col-sm-offset-2 col-sm-1 control-label">Factura</label>
			<div class="form-group col-sm-2">
	      		<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-koi-search-factura-component-table" data-field="factura1_orden">
							<i class="fa fa-building-o"></i>
						</button>
					</span>
					<input id="factura1_orden" placeholder="Factura" class="form-control factura-koi-component" name="factura1_orden" type="text" maxlength="15" data-factura="true" data-name="factura1_orden_beneficiario" required>
				</div>
			</div>
			<div class="col-sm-4">
				<input id="factura1_orden_beneficiario" name="factura1_orden_beneficiario" placeholder="Tercero" class="form-control input-sm" type="text" readonly required>
			</div>
		</div>

		<!-- table table-bordered table-striped -->
        <div id="wrapper-table-factura" class="box-body table-responsive no-padding" hidden>
            <table id="browse-factura-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="10%">Fecha</th>
                        <th width="10%">Vencimiento</th>
                        <th width="10%">Numero</th>
                        <th width="10%">Cuota</th>
                        <th width="10%">Saldo</th>
                        <th width="10%">A pagar</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Render content ordenes --}}
                </tbody>
            </table>
        </div>
	</script>

	<script type="text/template" id="add-rfacturap-asiento-tpl">
		<div class="row">
			<div class="form-group col-md-4">
				<label for="facturap1_vencimiento" class="control-label">Vencimiento</label>
				<input type="text" id="facturap1_vencimiento" name="facturap1_vencimiento" placeholder="Vencimiento" class="form-control input-sm datepicker" required>
			</div>

			<div class="form-group col-md-4">
				<label for="facturap1_cuotas" class="control-label">Cuotas</label>
				<input type="number" id="facturap1_cuotas" name="facturap1_cuotas" placeholder="Cuotas" class="form-control input-sm" value="2" min="1" max="100" required>
			</div>

			<div class="form-group col-md-4">
				<label for="facturap1_periodicidad" class="control-label">Periodicidad (días)</label>
				<input type="number" id="facturap1_periodicidad" name="facturap1_periodicidad" placeholder="Periodicidad" class="form-control input-sm" min="1" value="15" required>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<input type="hidden" id="facturap1_sucursal" class="form-control" name="facturap1_sucursal" value="1" required>
				<label for="facturap1_observaciones" class="control-label">Observaciones</label>
				<textarea id="facturap1_observaciones" name="facturap1_observaciones" class="form-control" rows="2" placeholder="Observaciones"></textarea>
			</div>
		</div>
	</script>

	<script type="text/template" id="add-rfacturap2-asiento-tpl">
		<div class="row">
			<!-- table table-bordered table-striped -->
			<div class="box-body table-responsive no-padding">
				<table id="browse-rfacturap2-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
		            <tr>
		                <th>Cuota</th>
		                <th>Vencimiento</th>
		                <th>Valor</th>
		                <th>Saldo</th>
		                <th></th>
		            </tr>
			    </table>
			</div>
		</div>
	</script>

	<script type="text/template" id="add-rfacturap2-item-tpl">
	    <td><%- facturap2_cuota %></td>
	    <td><%- facturap2_vencimiento %></td>
	    <td class="text-right"><%- window.Misc.currency(facturap2_valor) %></td>
	    <td class="text-right"><%- window.Misc.currency(facturap2_saldo) %></td>
	    <td>
			<input id="movimiento_valor_<%- id %>" name="movimiento_valor_<%- id %>" placeholder="Valor" class="form-control input-sm" data-currency type="text">
	    </td>
	</script>

	<script type="text/template" id="add-inventario-asiento-tpl">
		<div class="row">
			<div class="col-md-12 text-center">
				<label class="control-label">
					Seleccione producto de inventario para asociar al <%- asienton2_naturaleza == 'D' ? 'Débito' : 'Crédito' %>. Valor (<%- window.Misc.currency( asienton2_valor ) %>)
				</label>
				<% if(asienton2_naturaleza == 'C') { %>
					<br/>
					<label class="control-label text-red">
						El valor del Crédito puede ser modificado si es diferente al costo de movimiento.
					</label>
				<% } %>
			</div>
		</div>
		<br />
  	  	<div class="row">
            <div class="form-group col-sm-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="producto_codigo">
                            <i class="fa fa-barcode"></i>
                        </button>
                    </span>
                    <input id="producto_codigo" placeholder="Producto" class="form-control producto-koi-component evaluate-producto-movimiento-asiento" name="producto_codigo" type="text" maxlength="15" data-wrapper="traslados-create" data-name="producto_nombre" required>
                </div>
            </div>
            <div class="col-sm-4 col-xs-10">
                <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
            </div>

            <% if(asienton2_naturaleza == 'D') { %>
	            <div class="col-sm-1 col-xs-1">
	                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="producto" data-field="producto_codigo">
	                    <i class="fa fa-plus"></i>
	                </button>
	            </div>
            <% } %>

            <div class="form-group col-md-2">
                <input id="movimiento_cantidad" name="movimiento_cantidad" class="form-control input-sm evaluate-producto-movimiento-asiento" type="number" placeholder="Unidades" min="1" required>
			</div>

            <div class="form-group <%- asienton2_naturaleza == 'D' ? 'col-sm-3' : 'col-sm-4' %>">
                <select name="movimiento_sucursal" id="movimiento_sucursal" class="form-control evaluate-producto-movimiento-asiento" required>
                    <option value="" selected>Sucursal</option>
                    @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

		<div id="content-detail-inventory"></div>
	</script>

	<!-- Render table inventario -->
	<script type="text/template" id="add-itemrollo-asiento-tpl">
		<div class="row">
			<div class="col-sm-4 col-md-offset-4 col-xs-12">
				<!-- table table-bordered table-striped -->
				<div class="box-body table-responsive no-padding">
					<table id="browse-itemtollo-list" class="table table-hover table-bordered" cellspacing="0">
			            <tr>
			                <th>Item</th>
			                <th>Metros (m)</th>
			            </tr>
				    </table>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="choose-itemrollo-asiento-tpl">
		<div class="row">
			<div class="col-sm-6 col-md-offset-3 col-xs-12">
				<!-- table table-bordered table-striped -->
				<div class="box-body table-responsive no-padding">
					<table id="browse-chooseitemtollo-list" class="table table-hover table-bordered" cellspacing="0">
			            <tr>
			                <th>Item</th>
			                <th>Metros (m)</th>
			                <th>Saldo (m)</th>
			                <th></th>
			            </tr>
				    </table>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="add-series-asiento-tpl">
		<div class="row">
			<div class="col-sm-6 col-md-offset-3 col-xs-12">
				<!-- table table-bordered table-striped -->
				<div class="box-body table-responsive no-padding">
					<table id="browse-series-list" class="table table-hover table-bordered" cellspacing="0">
			            <tr>
			                <th>Item</th>
			                <th>Serie</th>
			            </tr>
				    </table>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="show-info-asienton2-tpl">
		<div class="row">
			<div class="form-group col-md-6">
				<label class="control-label">Naturaleza</label>
				<div><%- asienton2_naturaleza == 'D' ? 'Débito' : 'Crédito' %></div>
			</div>
		</div>

		<!-- Orden -->
		<% if( !_.isUndefined(asienton2_ordenp) && !_.isNull(asienton2_ordenp) && asienton2_ordenp != ''){ %>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Orden de producción</label>
					<div><%- ordenp_codigo %> - <%- ordenp_beneficiario %></div>
				</div>
			</div>
		<% } %>

		<!-- Beneficiario -->
		<div class="row">
			<div class="form-group col-md-12">
				<label class="control-label">Beneficiario</label>
				<div><%- tercero_nit %> - <%- tercero_nombre %></div>
			</div>
		</div>

		<!-- Centro costo -->
    	<% if( !_.isUndefined(asienton2_centro) && !_.isNull(asienton2_centro) && asienton2_centro != '') { %>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Centro Costo</label>
					<div><%- centrocosto_codigo %> - <%- centrocosto_nombre %></div>
				</div>
			</div>
		<% } %>

		<!-- Detalle -->
    	<% if( !_.isUndefined(asienton2_detalle) && !_.isNull(asienton2_detalle) && asienton2_detalle != '') { %>
			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Detalle</label>
					<div><%- asienton2_detalle %></div>
				</div>
			</div>
		<% } %>

		<div class="row" id="render-info-modal"></div>
	</script>

	<!-- Facturas, Facturap, Inventario -> Padres -->
	<script type="text/template" id="add-info-facturap-item">
		<div class="box box-success">
			<div class="box-body">
				<div class="box-header with-border">
		            <h3 class="box-title">
		            	<b>Factura proveedor </b><small>(<%- naturaleza == 'D' ? 'Debito' : 'Credito' %>)</small>
		            </h3>
		        </div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-6">
							<label class="control-label">Factura proveedor</label>
							<div><%- movimiento_facturap %></div>
						</div>
						<% if( movimiento_nuevo ) { %>
							<div class="form-group col-md-6">
								<label class="control-label">Valor</label>
								<div><%- window.Misc.currency( movimiento_valor ) %></div>
							</div>
						<% } %>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label class="control-label">Tercero</label>
							<div><%- tercero.tercero_nit %> - <%- tercero.tercero_nombre %></div>
						</div>
					</div>
					<% if( movimiento_nuevo ) { %>
						<div class="row">
							<div class="form-group col-md-4">
								<label class="control-label">Vencimiento</label>
								<div><%- movimiento_fecha %></div>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Cuotas</label>
								<div><%- movimiento_item %></div>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Periodicidad</label>
								<div><%- movimiento_periodicidad %></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<label class="control-label">Observaciones</label>
								<div><%- movimiento_observaciones %></div>
							</div>
						</div>
					<% } %>
				</div>
		    </div>
		</div>
		<% if ( !movimiento_nuevo ) { %>
			<div class="box box-success">
				<div class="box-body">
					<div class="box-header with-border">
			            <h3 class="box-title"><b>Informacion adicional</b></h3>
			        </div>

			        <div class="box-body table-responsive no-padding">
			            <table id="browse-showinfo-facturap-list" class="table table-hover table-bordered" cellspacing="0">
		                	<thead>
					        	<tr>
									<th class="text-center">Cuota</th>
					                <th class="text-center">Pago</th>
					            </tr>
					       	</thead>
					       	<tbody>
					       	</tbody>
					    </table>
			        </div>
				</div>
			</div>
		 <% } %>
	</script>

	<script type="text/template" id="add-info-factura-item">
		<div class="box box-success">
			<div class="box-body">
				<div class="box-header with-border">
					<h3 class="box-title">
						<b>Factura </b><small>(<%- naturaleza == 'D' ? 'Debito' : 'Credito' %>)</small>
					</h3>
					<div class="pull-right">
						<% if ( !_.isNull(movimiento_factura) ) { %>
							<b>Numero </b><small># <%- factura1_id %></small>
						<% } %>
						<b>Prefijo </b><small><%- puntoventa_prefijo %></small>
					</div>
		        </div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-6">
							<label class="control-label">Fecha</label>
							<div><%- factura1_fecha %></div>
						</div>
						<div class="form-group col-md-6">
							<label class="control-label">Vencimiento</label>
							<div><%- factura1_fecha_vencimiento %></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Punto de venta</label>
							<div><%- puntoventa_nombre %></div>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Valor</label>
							<div><%- window.Misc.currency( factura1_total ) %></div>
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Cuotas</label>
							<div><%- factura1_cuotas %></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-12">
							<label class="control-label">Tercero</label>
							<div><%- tercero_nit %> - <%- tercero_nombre %></div>
						</div>
					</div>
				</div>
		    </div>
		</div>

		<div class="box box-success">
			<div class="box-body">
				<div class="box-header with-border">
		            <h3 class="box-title"><b>Informacion adicional</b></h3>
		        </div>

		        <div class="box-body table-responsive no-padding">
		            <table id="browse-showinfo-factura-list" class="table table-hover table-bordered" cellspacing="0">
	                	<thead>
				        	<tr>
								<th class="text-center">Cuota No.</th>
				                <th class="text-center">Pago</th>
				            </tr>
				       	</thead>
				       	<tbody></tbody>
				    </table>
		        </div>
			</div>
		</div>
	</script>

	<script type="text/template" id="add-info-inventario-item">
		<div class="box box-success">
			<div class="box-body">
				<div class="box-header with-border">
		            <h3 class="box-title">
		              	<b>Inventario </b><small>(<%- naturaleza == 'D' ? 'Debito' : 'Credito' %>)</small>
		            </h3>
		        </div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label class="control-label">Tercero</label>
							<div><%- tercero.tercero_nit %> - <%- tercero.tercero_nombre %></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label class="control-label">Producto</label>
							<div><%- producto_codigo %> - <%- producto_nombre %></div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label class="control-label">Sucursal</label>
							<div><%- sucursal_nombre %></div>
						</div>
						<div class="form-group col-md-6">
							<label class="control-label">Cantidad</label>
							<div><%- movimiento_valor %></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="box box-success">
			<div class="box-body">
				<div class="box-header with-border">
		              <h3 class="box-title"><b>Informacion adicional</b></h3>
		        </div>

		        <div class="box-body table-responsive no-padding">
					<table id="browse-showinfo-asiento-list" class="table table-hover table-bordered" cellspacing="0">
	                	<thead>
                			<tr>
				                <th class="text-center first-row"></th>
				                <th class="text-center second-row"></th>
				            </tr>
				       	</thead>
				       	<tbody></tbody>
				    </table>
		        </div>
			</div>
		</div>
	</script>

	<!-- Detalles de las Facturas, Facturap, Inventario -> Hijos -->
	<script type="text/template" id="show-info-detalle-factura">
		<td class="text-center"><%- factura4_cuota %></td>
		<td class="text-center"><%- window.Misc.currency( movimiento_valor ) %></td>
	</script>

	<script type="text/template" id="show-info-detalle-facturap">
		<td class="text-center"><%- facturap2_cuota %></td>
		<td class="text-center"><%- window.Misc.currency( movimiento_valor ) %></td>
	</script>

	<script type="text/template" id="show-info-detalle-inventario">
		<% if ( !_.isNull( movimiento_serie ) ) { %>
			<td class="text-center"><%- movimiento_item %></td>
			<td class="text-center"><%- movimiento_serie %></td>
		<% }else{ %>
			<td class="text-center"><%- movimiento_item %></td>
			<td class="text-center"><%- movimiento_valor %></td>
		<% } %>
	</script>

    <script type="text/template" id="factura-item-list-tpl">
        <td><%- factura1_fecha %></td>
	    <td><%- factura4_vencimiento %></td>
	    <td><%- factura4_factura1 %></td>
	    <td><%- factura4_cuota %></td>
	    <td><%- window.Misc.currency(factura4_saldo) %></td>
	    <td><input type="text" id="factura4_pagar_<%- id %>" name="factura4_pagar_<%- id %>" class="form-control input-sm" data-currency-negative></td>
    </script>

    <script type="text/template" id="add-comments-item-tpl">
    	<td class="text-center">
			<a class="btn btn-default btn-xs item-factura-remove" data-resource="<%- id %>">
				<span><i class="fa fa-times"></i></span>
			</a>
		</td>
    	<td><%- factura3_observaciones %></td>
    </script>
@stop
