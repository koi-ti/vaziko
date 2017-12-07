@extends('accounting.plancuentasnif.main')

@section('breadcrumb')
	<li class="active">Plan de cuentas NIF</li>
@stop

@section('module')
	<div id="plancuentasnif-main">
		<div class="box box-success">
			<div class="box-body">
				{!! Form::open(['id' => 'form-koi-search-plancuentanif-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
					<div class="form-group">
						<label for="plancuentasn_cuenta" class="col-md-1 control-label">Cuenta</label>
						<div class="col-md-2">
							{!! Form::text('plancuentasn_cuenta', session('search_plancuentasn_cuenta'), ['id' => 'plancuentasn_cuenta', 'class' => 'form-control input-sm']) !!}
						</div>

						<label for="plancuentasn_nombre" class="col-md-1 control-label">Nombre</label>
						<div class="col-md-8">
							{!! Form::text('plancuentasn_nombre', session('search_plancuentasn_nombre'), ['id' => 'plancuentasn_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-3 col-md-2 col-xs-4">
							<button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
						</div>
						<div class="col-md-2 col-xs-4">
							<button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
						</div>
						<div class="col-md-2 col-xs-4">
							<a href="{{ route('plancuentasnif.create') }}" class="btn btn-default btn-block btn-sm">
								<i class="fa fa-plus"></i> Nueva
							</a>
						</div>
					</div>
				{!! Form::close() !!}

				<div class="table-responsive">
					<table id="plancuentasnif-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Cuenta</th>
				                <th>Nivel</th>
				                <th>Nombre</th>
				                <th>Naturaleza</th>
				                <th>Tercero</th>
				                <th>Tipo</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
	</div>
@stop
