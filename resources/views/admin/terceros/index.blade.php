@extends('admin.terceros.main')

@section('breadcrumb')	
	<li class="active">Terceros</li>
@stop

@section('module')	
	<div id="terceros-main">
		<div class="box box-success">
			<div class="box-body table-responsive">
				<table id="terceros-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Nit</th>
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
@stop