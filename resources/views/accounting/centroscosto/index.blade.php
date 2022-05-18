@extends('accounting.centroscosto.main')

@section('breadcrumb')
	<li class="active">Centros de costo</li>
@stop

@section('module')
	<div id="centroscosto-main" class="box box-success">
		<div class="box-body table-responsive">
			<table id="centroscosto-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
		        <thead>
		            <tr>
		                <th>Código</th>
		                <th>Centro</th>
		                <th>Nombre</th>
		                <th>Titulo</th>
		                <th>Activo</th>
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
@stop
