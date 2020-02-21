@extends('accounting.asientonif.main')

@section('module')
	<section class="content-header">
		<h1>
			Asientos contables nif <small>Administración asientos contables nif</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li><a href="{{ route('asientos.index') }}">Asientos contables nif</a></li>
			<li class="active">{{ $asientoNif->id }}</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-success" id="asientosnif-show">
			<div class="box-body">
				<div class="row">
					<div class="form-group col-md-1">
						<label for="asienton1_ano" class="control-label">Año</label>
						<div>{{ $asientoNif->asienton1_ano }}</div>
					</div>
					<div class="form-group col-md-1">
						<label for="asienton1_mes" class="control-label">Mes</label>
						<div>{{ $asientoNif->asienton1_mes ? config('koi.meses')[$asientoNif->asienton1_mes] : ''  }}</div>
					</div>
					<div class="form-group col-md-1">
						<label for="asienton1_dia" class="control-label">Día</label>
						<div>{{ $asientoNif->asienton1_dia }}</div>
					</div>
					@ability ('exportar' | 'asientosnif')
						<div class="col-md-1 col-md-offset-8 col-sm-6 col-xs-6 text-right">
							<a href="{{ route('asientosnif.exportar', ['asientosnif' => $asientoNif->id]) }}" class="btn btn-danger btn-sm btn-block">
								<i class="fa fa-file-pdf-o"></i>
							</a>
						</div>
					@endability
				</div>
				<div class="row">
					<div class="form-group col-md-3 col-xs-10">
						<label for="asienton1_folder" class="control-label">Folder</label>
						<div>{{ $asientoNif->folder_nombre }}</div>
					</div>
					<div class="form-group col-md-3">
						<label for="asienton1_documento" class="control-label">Documento</label>
						<div>{{ $asientoNif->documento_nombre }}</div>
					</div>
					<div class="form-group col-md-2">
						<label for="asienton1_numero" class="control-label">Número</label>
						<div>{{ $asientoNif->asienton1_numero }}</div>
					</div>
					@if ($asientoNif->asienton1_preguardado)
						<div class="form-group col-md-offset-2 col-md-2 text-right">
							<span class="label label-warning">PRE-GUARDADO</span>
						</div>
					@endif
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<label for="asienton1_beneficiario" class="control-label">Beneficiario</label>
						<div>
							<a href="{{ route('terceros.show', ['terceros' =>  $asientoNif->asienton1_beneficiario ]) }}">
								{{ $asientoNif->tercero_nit }}
							</a>- {{ $asientoNif->tercero_nombre }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<label for="asienton1_detalle" class="control-label">Detalle</label>
						<div>{{ $asientoNif->asienton1_detalle }}</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2">
						<label class="control-label">Usuario elaboro</label>
						<div>
							<a href="{{ route('terceros.show', ['terceros' =>  $asientoNif->asienton1_usuario_elaboro ]) }}" title="Ver tercero">
								{{ $asientoNif->username_elaboro }}</a>
						</div>
					</div>
					<div class="form-group col-md-2">
						<label class="control-label">Fecha elaboro</label>
						<div>{{ $asientoNif->asienton1_fecha_elaboro }}</div>
					</div>
				</div><br>
        		<div class="row">
					<div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('asientosnif.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
					</div>
				</div><br>
				<div class="box-body table-responsive">
					<table id="browse-detalle-asienton-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
			            <tr>
			                <th>Cuenta</th>
			                <th>Nombre</th>
			                <th>Beneficiario</th>
			                <th>Centro Costo</th>
							@ability ('precios' | 'asientosnif')
				                <th>Base</th>
				                <th>Debito</th>
				                <th>Credito</th>
				                <th></th>
							@endability
			            </tr>
						@ability ('precios' | 'asientosnif')
				            <tfoot>
								<tr>
									<td colspan="4"></td>
									<th class="text-left">Total</th>
									<td class="text-right" id="total-debitos">0</td>
									<td class="text-right" id="total-creditos">0</td>
									<td></td>
								</tr>
							</tfoot>
						@endability
				    </table>
				</div>
			</div>
		</div>
	</section>
@stop
