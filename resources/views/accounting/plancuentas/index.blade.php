@extends('accounting.plancuentas.main')

@section('breadcrumb')
	<li class="active">Plan de cuentas</li>
@stop

@section('module')
	<div id="plancuentas-main" class="box box-success">
		<div class="box-body">
			{!! Form::open(['id' => 'form-koi-search-plancuenta-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
				<div class="form-group">
					<label for="plancuentas_cuenta" class="col-md-1 control-label">Cuenta</label>
					<div class="col-md-2">
						{!! Form::text('plancuentas_cuenta', session('search_plancuentas_cuenta'), ['id' => 'plancuentas_cuenta', 'class' => 'form-control input-sm']) !!}
					</div>

					<label for="plancuentas_nombre" class="col-md-1 control-label">Nombre</label>
					<div class="col-md-8">
						{!! Form::text('plancuentas_nombre', session('search_plancuentas_nombre'), ['id' => 'plancuentas_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
					</div>
				</div>

				<div class="form-group">
					<div class="@ability ('crear' | 'plancuentas') col-md-offset-3 @elseability col-md-offset-4 @endability col-md-2 col-xs-4">
						<button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
					</div>
					<div class="col-md-2 col-xs-4">
						<button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
					</div>
					@ability ('crear' | 'plancuentas')
						<div class="col-md-2 col-xs-4">
							<a href="{{ route('plancuentas.create') }}" class="btn btn-default btn-block btn-sm">
								<i class="fa fa-plus"></i> Nuevo plan de cuentas
							</a>
						</div>
					@endability
				</div>
			{!! Form::close() !!}

			<div class="table-responsive">
				<table id="plancuentas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
			        <thead>
			            <tr>
			                <th>Cuenta</th>
			                <th>Nivel</th>
			                <th>Nombre</th>
			                <th>Naturaleza</th>
			                <th>Tercero</th>
			                <th>Cuenta Nif</th>
							<th>Tipo</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</div>
@stop
