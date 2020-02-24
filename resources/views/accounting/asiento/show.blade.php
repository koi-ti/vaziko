@extends('accounting.asiento.main')

@section('module')
	<section class="content-header">
		<h1>
			Asientos contables <small>Administración asientos contables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
			<li class="active">{{ $asiento->id }}</li>
		</ol>
	</section>

	<section class="content" id="asientos-show">
		<div class="box box-success spinner-main">
			<div class="box-body">
				<div class="row">
					<div class="form-group col-md-1">
						<label for="asiento1_ano" class="control-label">Año</label>
						<div>{{ $asiento->asiento1_ano }}</div>
					</div>
					<div class="form-group col-md-1">
						<label for="asiento1_mes" class="control-label">Mes</label>
						<div>{{ $asiento->asiento1_mes ? config('koi.meses')[$asiento->asiento1_mes] : ''  }}</div>
					</div>
					<div class="form-group col-md-1">
						<label for="asiento1_dia" class="control-label">Día</label>
						<div>{{ $asiento->asiento1_dia }}</div>
					</div>

					@ability ('exportar' | 'asientos')
						<div class="col-md-1 col-md-offset-8 col-sm-6 col-xs-6 text-right">
							<a href="{{ route('asientos.exportar', ['asientos' => $asiento->id]) }}" target="_blank" class="btn btn-default btn-sm btn-block">
								<i class="fa fa-file-pdf-o"></i>
							</a>
						</div>
					@endability
				</div>

				<div class="row">
					<div class="form-group col-md-3 col-xs-10">
						<label for="asiento1_folder" class="control-label">Folder</label>
						<div>{{ $asiento->folder_nombre }}</div>
					</div>

					<div class="form-group col-md-3">
						<label for="asiento1_documento" class="control-label">Documento</label>
						<div>{{ $asiento->documento_nombre }}</div>
					</div>

					<div class="form-group col-md-2">
						<label for="asiento1_numero" class="control-label">Número</label>
						<div>{{ $asiento->asiento1_numero }}</div>
					</div>
					@if ($asiento->asiento1_preguardado)
						<div class="form-group col-md-offset-2 col-md-2 text-right">
							<span class="label label-warning">PRE-GUARDADO</span>
						</div>
					@endif
				</div>

				<div class="row">
					<div class="form-group col-md-9">
						<label for="asiento1_beneficiario" class="control-label">Beneficiario</label>
						<div>
							<a href="{{ route('terceros.show', ['terceros' =>  $asiento->asiento1_beneficiario ]) }}">
								{{ $asiento->tercero_nit }}
							</a>- {{ $asiento->tercero_nombre }}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-9">
						<label for="asiento1_detalle" class="control-label">Detalle</label>
						<div>{{ $asiento->asiento1_detalle ?: '-' }}</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-2">
						<label class="control-label">Usuario elaboró</label>
						<div>
							<a href="{{ route('terceros.show', ['terceros' =>  $asiento->asiento1_usuario_elaboro ]) }}" title="Ver tercero">
								{{ $asiento->username_elaboro }}</a>
						</div>
					</div>
					<div class="form-group col-md-2">
						<label class="control-label">Fecha elaboró</label>
						<div>{{ $asiento->asiento1_fecha_elaboro }}</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-md-2 col-md-offset-{{ $asiento->asiento1_documentos == NULL ? 4 : 5 }} col-sm-6 col-xs-6 text-left">
						<a href="{{ route('asientos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
					</div>
					@ability ('editar' | 'asientos')
						@if ($asiento->asiento1_documentos == NULL)
							<div class="col-md-2 col-sm-6 col-xs-6 text-right">
								<a href="#" class="btn btn-primary btn-sm btn-block reverse-asiento">{{ trans('app.edit') }}</a>
							</div>
						@endif
					@endability
				</div>
			</div>
		</div>

		<div class="box box-success spinner-main">
			<div class="box-body">
				<div class="table-responsive">
					<table id="browse-detalle-asiento-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
						<thead>
							@ability ('precios' | 'asientos')
								<tr>
									<td colspan="4"></td>
									<th class="text-left">Total</th>
									<td class="text-right total-debitos">0</td>
									<td class="text-right total-creditos">0</td>
									<td></td>
								</tr>
							@endability
							<tr>
								<th>Cuenta</th>
								<th>Nombre</th>
								<th>Beneficiario</th>
								<th>Centro Costo</th>
								@ability ('precios' | 'asientos')
									<th>Base</th>
									<th>Débito</th>
									<th>Crédito</th>
									<th></th>
								@endability
							</tr>
						</thead>
						<tbody>
						</tbody>
						@ability ('precios' | 'asientos')
							<tfoot>
								<tr>
									<td colspan="4"></td>
									<th class="text-left">Total</th>
									<td class="text-right total-debitos">0</td>
									<td class="text-right total-creditos">0</td>
									<td></td>
								</tr>
							</tfoot>
						@endability
					</table>
				</div>
			</div>
		</div>
	</section>

	<script type="text/template" id="asiento-reverse-confirm-tpl">
		<p>Si edita el asiento contable y las cuentas manejan inventario, cartera ó cuentas por pagar se eliminaran los registros y se crearan de nuevo.</p>
	</script>

	<script type="text/template" id="asiento-anular-confirm-tpl">
		<p>¿Está seguro que desea eliminar el asiento <b>{{ $asiento->asiento1_numero }}</b>?</p>
	</script>

	<script type="text/template" id="add-asiento2-item-tpl">
		<td><%- plancuentas_cuenta %></td>
	    <td><%- plancuentas_nombre %></td>
	    <td>
	    	<a href="<%- window.Misc.urlFull( Route.route('terceros.show', {terceros: asiento2_beneficiario}) ) %>" title="<%- tercero_nombre %>" target="_blank">
	    		<%- tercero_nit %>
	    	</a>
	    </td>
	    <td>
	    	<% if( !_.isUndefined(asiento2_centro) && !_.isNull(asiento2_centro) && asiento2_centro != '') { %>
		    	<a href="<%- window.Misc.urlFull( Route.route('centroscosto.show', {centroscosto: asiento2_centro}) ) %>" title="<%- centrocosto_nombre %>" target="_blank">
		    		<%- centrocosto_codigo %>
		    	</a>
	    	<% } %>
	    </td>
	    @if (auth()->user()->ability('admin', 'precios', ['module' => 'asientos']))
	        <td class="text-right"><%- window.Misc.currency(asiento2_base ? asiento2_base : 0) %></td>
	        <td class="text-right"><%- window.Misc.currency(asiento2_debito ? asiento2_debito : 0) %></td>
	        <td class="text-right"><%- window.Misc.currency(asiento2_credito ? asiento2_credito: 0) %></td>
	    @endif
	    <td class="text-center" width="2%">
			<a class="btn btn-default btn-xs item-show" data-resource="<%- id %>">
				<span><i class="fa fa-info-circle"></i></span>
			</a>
		</td>
	</script>
@stop
