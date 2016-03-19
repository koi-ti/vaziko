@extends('layout.layout')

@section('content')
    <section class="content-header">
		<h1>
			Actividades Económicas <small>Administración de actividades económicas</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Actividades</li>
		</ol>
    </section>

	<section class="content">
		<div id="actividades-main">
			<div class="box box-success">
				<div class="box-body table-responsive">
					<table id="actividades-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
		</div>
    </section>    
@stop
