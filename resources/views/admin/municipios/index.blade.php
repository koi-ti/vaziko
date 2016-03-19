@extends('layout.layout')

@section('content')
    <section class="content-header">
		<h1>
			Municipios <small>Administración de minicipios</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Municipios</li>
		</ol>
    </section>

	<section class="content">
		<div id="municipios-main">
			<div class="box box-success">
				<div class="box-body table-responsive">
					<table id="municipios-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Codigo Dpto.</th>
				                <th>Departamento</th>
				                <th>Codigo Mpio.</th>
				                <th>Municipio</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
    </section>    
@stop
