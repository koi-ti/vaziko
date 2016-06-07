@extends('accounting.asiento.main')

@section('breadcrumb')	
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
        <div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('asientos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
				</div>
				<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
					<button type="button" class="btn btn-primary btn-sm btn-block submit-asiento">{{ trans('app.create') }}</button>
				</div>
			</div>
		</div>

		<div class="box-body" id="render-form-asientos">
			{{-- Render form asientos --}}
		</div>
	</div>

	<script type="text/template" id="add-asiento-tpl">
		<form method="POST" accept-charset="UTF-8" id="form-asientos" data-toggle="validator">
			<div class="row">
				<label for="asiento1_ano" class="col-sm-1 control-label">Fecha</label>
				<div class="form-group col-sm-2">
					<input id="asiento1_ano" value="{{ date('Y') }}" placeholder="Año" class="form-control input-sm input-toupper" name="asiento1_ano" type="number" maxlength="4" data-minlength="4" required>
				</div>

				<div class="form-group col-sm-2">
					<select name="asiento1_mes" id="asiento1_mes" class="form-control" required>
						@foreach( config('koi.meses') as $key => $value)
							<option value="{{ $key }}" {{ date('m') == $key ? 'selected': '' }} >{{ $value }}</option>

						@endforeach
					</select>
				</div>

				<div class="form-group col-sm-1">
					<select name="asiento1_dia" id="asiento1_dia" class="form-control" required>
						@for($i = 1; $i <= 31; $i++)
							<option value="{{ $i }}" {{ date('d') == $i ? 'selected': '' }} >{{ $i }}</option>
						@endfor
					</select>
				</div>
			</div>

			<div class="row">
				<label for="asiento1_folder" class="col-sm-1 control-label">Folder</label>
				<div class="form-group col-sm-3">
					<select name="asiento1_folder" id="asiento1_folder" class="form-control select-filter-document-koi-component" data-wrapper="asientos-create" data-documents="asiento1_documento" required>
						<option value="" selected>Seleccione</option>
						@foreach( App\Models\Accounting\Folder::getFolders() as $key => $value)
							<option value="{{ $key }}" >{{ $value }}</option>
						@endforeach
					</select>
				</div>

				<label for="asiento1_documento" class="col-sm-1 control-label">Documento</label>
				<div class="form-group col-sm-3">
					<select name="asiento1_documento" id="asiento1_documento" class="form-control" required>
						<option value="" selected>Seleccione</option>
					</select>
				</div>

				<label for="asiento1_numero" class="col-sm-1 control-label">Número</label>
				<div class="form-group col-sm-2">
					<input id="asiento1_numero" name="asiento1_numero" value="" placeholder="Número" class="form-control input-sm input-toupper" type="number" required>
				</div>
            </div> 

			<div class="row">
				<label for="asiento1_beneficiario" class="col-sm-1 control-label">Beneficiario</label>
				<div class="form-group col-sm-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat" data-field="asiento1_beneficiario">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="asiento1_beneficiario" placeholder="Beneficiario" class="form-control tercero-koi-component" name="asiento1_beneficiario" type="text" maxlength="15" data-wrapper="asientos-create" data-name="asiento1_beneficiario_nombre" required>		
					</div>
				</div>
				<div class="col-sm-5">
					<input id="asiento1_beneficiario_nombre" name="asiento1_beneficiario_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" disabled required>
				</div>
			</div>

			<div class="row">
				<label for="asiento1_detalle" class="col-sm-1 control-label">Detalle</label>
				<div class="form-group col-sm-10">
					<textarea id="asiento1_detalle" name="asiento1_detalle" class="form-control" rows="2" placeholder="Detalle"></textarea>
				</div>
            </div> 
		</form>
		
		<!-- Detalle -->
		<div class="box box-success">
			<form method="POST" accept-charset="UTF-8" id="form-item-asiento" data-toggle="validator">
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-2">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat" data-field="asiento2_cuenta">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="asiento2_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="asiento2_cuenta" type="text" maxlength="15" data-wrapper="asientos-create" data-name="asiento2_cuenta_nombre" required>		
							</div>
						</div>
						<div class="col-sm-4">
							<input id="asiento2_cuenta_nombre" name="asiento2_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled required>
						</div>

						<div class="form-group col-sm-6">
							<select name="asiento2_centro" id="asiento2_centro" class="form-control select2-default-clear"  data-placeholder="Seleccione centro de costo">
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
									<button type="button" class="btn btn-default btn-flat" data-field="asiento2_beneficiario_nit">
										<i class="fa fa-user"></i>
									</button>
								</span>
								<input id="asiento2_beneficiario_nit" placeholder="Beneficiario" class="form-control tercero-koi-component" name="asiento2_beneficiario_nit" type="text" maxlength="15" data-wrapper="asientos-create" data-name="asiento2_beneficiario_nombre" required>		
							</div>
						</div>
						<div class="col-sm-4">
							<input id="asiento2_beneficiario_nombre" name="asiento2_beneficiario_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" disabled required>
						</div>

						<div class="form-group col-sm-3">
							<label class="radio-inline" for="asiento2_naturaleza_debito">
								<input type="radio" id="asiento2_naturaleza_debito" name="asiento2_naturaleza" value="D" checked> Débito
							</label>

							<label class="radio-inline" for="asiento2_naturaleza_credito">
								<input type="radio" id="asiento2_naturaleza_credito" name="asiento2_naturaleza" value="C"> Crédito
							</label>
						</div>

						<div class="form-group col-sm-2">
							<input id="asiento2_base" name="asiento2_base" placeholder="Base" class="form-control input-sm" type="text" data-currency>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-9">
							<input id="asiento2_detalle" name="asiento2_detalle" class="form-control input-sm" placeholder="Detalle" type="text">
						</div>
						<div class="form-group col-sm-2">
							<input id="asiento2_valor" name="asiento2_valor" placeholder="Valor" class="form-control input-sm" type="text" data-currency required>
						</div>
						<div class="form-group col-sm-1">
							<button type="submit" class="btn btn-success btn-sm btn-block">
								<i class="fa fa-plus"></i>
							</button>
						</div>
		            </div> 
				</div>
			</form>

			<div class="box-body table-responsive">
				<table id="browse-detalle-asiento-list" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Cuenta</th>
			                <th>Nombre</th>
			                <th>Beneficiario</th>
			                <th>Centro Costo</th>
			                <th>Base</th>
			                <th>Debito</th>
			                <th>Credito</th>
			                <th>Detalle</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</script>
@stop