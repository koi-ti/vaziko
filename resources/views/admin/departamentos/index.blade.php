@extends('layout.layout')

@section('title') Departamentos @stop

@section('content')
    <section class="content-header">
		<h1>
			Departamentos <small>Administración de departamentos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Departamentos</li>
		</ol>
    </section>

	<section class="content">
		<div id="departamentos-main">
			<div class="box box-success">
				<div class="box-body table-responsive">
					<table id="departamentos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Codigo</th>
				                <th>Nombre</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
    </section>    
@stop
