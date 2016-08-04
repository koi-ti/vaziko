@extends('layout.layout')

@section('title') Asientos contables @stop

@section('content')
    <section class="content-header">
		<h1>
			Asientos contables <small>Administración asientos contables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			@yield('breadcrumb')
		</ol>
    </section>

	<section class="content">
    	@yield('module')
    </section>

    {{-- Templates --}}
    <script type="text/template" id="add-asiento-tpl">
		<form method="POST" accept-charset="UTF-8" id="form-asientos" data-toggle="validator">
			<div class="row">
				<label for="asiento1_ano" class="col-sm-1 control-label">Fecha</label>
				<div class="form-group col-sm-2">
					<input id="asiento1_ano" value="<%- asiento1_ano %>" placeholder="Año" class="form-control input-sm input-toupper" name="asiento1_ano" type="number" maxlength="4" data-minlength="4" required>
				</div>

				<div class="form-group col-sm-2">
					<select name="asiento1_mes" id="asiento1_mes" class="form-control" required>
						@foreach( config('koi.meses') as $key => $value)
							<option value="{{ $key }}" <%- asiento1_mes == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-sm-1">
					<select name="asiento1_dia" id="asiento1_dia" class="form-control" required>
						@for($i = 1; $i <= 31; $i++)
							<option value="{{ $i }}" <%- asiento1_dia == '{{ $i }}' ? 'selected': ''%>>{{ $i }}</option>
						@endfor
					</select>
				</div>
			</div>

			<div class="row">
				<label for="asiento1_folder" class="col-sm-1 control-label">Folder</label>
				<div class="form-group col-sm-3">
					<select name="asiento1_folder" id="asiento1_folder" class="form-control select2-default select-filter-document-koi-component" data-wrapper="asientos-create" data-documents="asiento1_documento" required>
						<option value="" selected>Seleccione</option>
						@foreach( App\Models\Accounting\Folder::getFolders() as $key => $value)
							<option value="{{ $key }}" <%- asiento1_folder == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
						@endforeach
					</select>
				</div>

				<label for="asiento1_documento" class="col-sm-1 control-label">Documento</label>
				<div class="form-group col-sm-3">
					<select name="asiento1_documento" id="asiento1_documento" class="form-control select2-default" required>
						<option value="" selected>Seleccione</option>
						@foreach( App\Models\Accounting\Documento::getDocuments() as $key => $value)
							<option value="{{ $key }}" <%- asiento1_documento == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
						@endforeach
					</select>
				</div>

				<label for="asiento1_numero" class="col-sm-1 control-label">Número</label>
				<div class="form-group col-sm-2">
					<input id="asiento1_numero" name="asiento1_numero" value="<%- asiento1_numero %>" placeholder="Número" class="form-control input-sm input-toupper" type="number" required>
				</div>
            </div>

			<div class="row">
				<label for="asiento1_beneficiario" class="col-sm-1 control-label">Beneficiario</label>
				<div class="form-group col-sm-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="asiento1_beneficiario">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="asiento1_beneficiario" placeholder="Beneficiario" class="form-control tercero-koi-component" name="asiento1_beneficiario" type="text" maxlength="15" data-wrapper="asientos-create" data-name="asiento1_beneficiario_nombre" value="<%- tercero_nit %>" required>
					</div>
				</div>
				<div class="col-sm-5">
					<input id="asiento1_beneficiario_nombre" name="asiento1_beneficiario_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" disabled required>
				</div>
			</div>

			<div class="row">
				<label for="asiento1_detalle" class="col-sm-1 control-label">Detalle</label>
				<div class="form-group col-sm-10">
					<textarea id="asiento1_detalle" name="asiento1_detalle" class="form-control" rows="2" placeholder="Detalle"><%- asiento1_detalle %></textarea>
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
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="plancuentas_cuenta">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="plancuentas_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="plancuentas_cuenta" type="text" maxlength="15" data-wrapper="asientos-create" data-name="plancuentas_nombre" data-base="asiento2_base" data-valor="asiento2_valor" data-centro="asiento2_centro" data-tasa="asiento2_tasa" required>
							</div>
						</div>
						<div class="col-sm-4">
							<input id="plancuentas_nombre" name="plancuentas_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled required>
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
									<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tercero_nit">
										<i class="fa fa-user"></i>
									</button>
								</span>
								<input id="tercero_nit" placeholder="Beneficiario" class="form-control tercero-koi-component" name="tercero_nit" type="text" maxlength="15" data-wrapper="asientos-create" data-name="tercero_nombre">
							</div>
						</div>
						<div class="col-sm-4">
							<input id="tercero_nombre" name="tercero_nombre" placeholder="Nombre beneficiario" class="form-control input-sm" type="text" maxlength="15" disabled>
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
							<input id="asiento2_base" name="asiento2_base" placeholder="Base" class="form-control input-sm currency" readonly="readonly" type="text">
							<input id="asiento2_tasa" name="asiento2_tasa" type="hidden">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-9">
							<input id="asiento2_detalle" name="asiento2_detalle" class="form-control input-sm" placeholder="Detalle" type="text">
						</div>
						<div class="form-group col-sm-2">
							<input id="asiento2_valor" name="asiento2_valor" placeholder="Valor" class="form-control input-sm currency" type="text" required>
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
				<table id="browse-detalle-asiento-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
		            <tr>
		                <th></th>
		                <th>Cuenta</th>
		                <th>Nombre</th>
		                <th>Beneficiario</th>
		                <th>Centro Costo</th>
		                <th>Base</th>
		                <th>Debito</th>
		                <th>Credito</th>
		                <th>Detalle</th>
		            </tr>
			    </table>
			</div>
		</div>
	</script>
@stop
