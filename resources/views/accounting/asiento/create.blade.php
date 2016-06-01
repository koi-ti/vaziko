@extends('accounting.asiento.main')

@section('breadcrumb')	
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
		{!! Form::open(['id' => 'form-asientos', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('asientos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-asientos">
				{{-- Render form asientos --}}
			</div>
		{!! Form::close() !!}
	</div>

	<script type="text/template" id="add-asiento-tpl">
		<div class="row">
			<div class="form-group col-md-1">
				<label for="asiento1_ano" class="control-label">Año</label>	
				<input id="asiento1_ano" value="{{ date('Y') }}" placeholder="Año" class="form-control input-sm input-toupper" name="asiento1_ano" type="text" maxlength="4" required>
			</div>
			<div class="form-group col-md-2">
				<label for="asiento1_mes" class="control-label">Mes</label>	
				<select name="asiento1_mes" id="asiento1_mes" class="form-control" required>
					@foreach( config('koi.meses') as $key => $value)
						<option value="{{ $key }}" {{ date('m') == $key ? 'selected': '' }} >{{ $value }}</option>

					@endforeach
				</select>
			</div>
			<div class="form-group col-md-1">
				<label for="asiento1_dia" class="control-label">Día</label>	
				<select name="asiento1_dia" id="asiento1_dia" class="form-control" required>
					@for($i = 1; $i <= 31; $i++)
						<option value="{{ $i }}" {{ date('d') == $i ? 'selected': '' }} >{{ $i }}</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3 col-xs-10">
				<label for="asiento1_folder" class="control-label">Folder</label>
				<select name="asiento1_folder" id="asiento1_folder" class="form-control select-filter-document-koi-component" data-wrapper="asientos-create" data-documents="asiento1_documento" required>
					<option value="" selected>Seleccione</option>
					@foreach( App\Models\Accounting\Folder::getFolders() as $key => $value)
						<option value="{{ $key }}" >{{ $value }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group col-md-3">
				<label for="asiento1_documento" class="control-label">Documento</label>
				<select name="asiento1_documento" id="asiento1_documento" class="form-control" required>
					<option value="" selected>Seleccione</option>
				</select>
			</div>

			<div class="form-group col-md-2">
				<label for="asiento1_numero" class="control-label">Número</label>	
				<input id="asiento1_numero" name="asiento1_numero" value="" placeholder="Número" class="form-control input-sm input-toupper" type="text" required>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-3">
				<label for="asiento1_beneficiario" class="control-label">Beneficiario</label>
	      		<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat" data-field="asiento1_beneficiario">
							<i class="fa fa-user"></i>
						</button>
					</span>
					<input id="asiento1_beneficiario" placeholder="Beneficiario" class="form-control tercero-koi-component" name="asiento1_beneficiario" type="text" maxlength="15" data-wrapper="asientos-create" data-name="asiento1_beneficiario_nombre" required>		
				</div>
			</div>

			<div class="form-group col-md-6">
				<label for="asiento1_beneficiario_nombre" class="control-label"></label>	
				<input id="asiento1_beneficiario_nombre" name="asiento1_beneficiario_nombre" class="form-control input-sm" type="text" maxlength="15" readonly required>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-9">
				<label for="asiento1_detalle" class="control-label">Detalle</label>
				<textarea id="asiento1_detalle" name="asiento1_detalle" class="form-control" rows="3" placeholder="Detalle"></textarea>
			</div>
		</div>
	</script>
@stop