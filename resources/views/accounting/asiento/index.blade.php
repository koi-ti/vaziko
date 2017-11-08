@extends('accounting.asiento.main')

@section('module')
	<section class="content-header">
		<h1>
			Asientos contables <small>Administración asientos contables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Asientos contables</li>
		</ol>
	</section>

	<section class="content">
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
	</section>
@stop
