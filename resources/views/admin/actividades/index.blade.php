@extends('admin.actividades.main')

@section('breadcrumb')
    <li class="active">Actividades</li>
@stop

@section('module')
	<div id="actividades-main" class="box box-success">
		<div class="box-body table-responsive">
			<table id="actividades-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
		        <thead>
		            <tr>
		                <th>Codigo</th>
		                <th>Nombre</th>
		                <th>Categoria</th>
		                <th>% Cree</th>
		            </tr>
		        </thead>
		    </table>
		</div>
	</div>
@stop
