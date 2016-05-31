@extends('accounting.plancuentas.main')

@section('breadcrumb')	
	<li class="active">Plan de cuentas</li>
@stop

@section('module')
	<div id="plancuentas-main">
		<div class="box box-success">
			<div class="box-body table-responsive">
				<table id="plancuentas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Cuenta</th>
			                <th>Nivel</th>
			                <th>Nombre</th>
			                <th>Naturaleza</th>
			                <th>Tercero</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</div>
@stop
