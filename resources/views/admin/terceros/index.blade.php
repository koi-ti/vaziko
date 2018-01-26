@extends('admin.terceros.main')

@section('breadcrumb')
	<li class="active">Terceros</li>
@stop

@section('module')
	<div id="terceros-main">
		<div class="box box-success">
			<div class="box-body">
				{!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
					<div class="form-group">
						<label for="tercero_nit" class="col-md-1 control-label">Documento</label>
						<div class="col-md-2">
							{!! Form::text('tercero_nit', session('search_tercero_nit'), ['id' => 'tercero_nit', 'class' => 'form-control input-sm']) !!}
						</div>

						<label for="tercero_nombre" class="col-md-1 control-label">Nombre</label>
						<div class="col-md-8">
							{!! Form::text('tercero_nombre', session('search_tercero_nombre'), ['id' => 'tercero_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
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
							<a href="{{ route('terceros.create') }}" class="btn btn-default btn-block btn-sm">
								<i class="fa fa-user-plus"></i> Nuevo
							</a>
						</div>
					</div>
				{!! Form::close() !!}

				<div class="table-responsive">
					<table id="terceros-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Documento</th>
				                <th>Nombre</th>
				                <th>Razon Social</th>
				                <th>Nombre1</th>
				                <th>Nombre2</th>
				                <th>Apellido1</th>
				                <th>Apellido2</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
	</div>
@stop
