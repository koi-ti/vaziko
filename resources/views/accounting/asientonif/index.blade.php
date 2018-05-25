@extends('accounting.asientonif.main')

@section('module')
	<section class="content-header">
		<h1>
			Asientos contables nif <small>Administración asientos contables nif</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Asientos contables nif</li>
		</ol>
	</section>

	<section class="content">
		<div id="asientosnif-main">
			<div class="box box-success">
				<div class="box-body table-responsive">
					<table id="asientosnif-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
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
	</section>
@stop
