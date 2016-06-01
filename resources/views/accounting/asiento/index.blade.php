@extends('accounting.asiento.main')

@section('breadcrumb')	
	<li class="active">Asientos contables</li>
@stop

@section('module')
	<div id="asientos-main">
		<div class="box box-success">
			<div class="box-body table-responsive">
				<table id="asientos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Número</th>
			                <th>Año</th>
			                <th>Mes</th>
			                <th>Tercero</th>
			                <th>Nombre</th>
			            </tr>
			        </thead>
			    </table>
			</div>
		</div>
	</div>
@stop
