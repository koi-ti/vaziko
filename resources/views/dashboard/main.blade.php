@extends('layout.layout')

@section('title') Dashboard @stop

@section('content')
	<section class="content-header">
		<h1>
			Dashboard
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
			@yield('breadcrumb')
		</ol>
	</section>
	<section class="content">
		<div class="box box-success">
			<div class="box-body">
				<div class="row">
					<div class="col-md-1">
						<a class="btn btn-app btn-koi-search-tercero-component-table" data-render="show" title="Ver terceros">
							<i class="fa fa-users"></i> Terceros
						</a>
					</div>
					<div class="col-md-1">
						<a class="btn btn-app btn-koi-search-producto-component" data-render="show" title="Ver productos">
							<i class="fa fa-wrench"></i> Insumos
						</a>
					</div>
					<div class="col-md-1">
						<a class="btn btn-app btn-koi-search-orden-component-table" data-render="show" title="Ver ordenes">
							<i class="fa fa-building-o"></i> Ordenes
						</a>
					</div>
				</div>

				<div class="row">
					<div class="col-md-1">
						<a class="btn btn-app btn-koi-search-cotizacion-component-table" data-render="show" title="Ver cotizacioness">
							<i class="fa fa-puzzle-piece"></i> Cotizaciones
						</a>
					</div>
					<div class="col-md-1">
						<a class="btn btn-app" href="{{ route('tiemposp.index') }}" title="Ver tiempos de producción">
							<i class="fa fa-clock-o"></i> Tiempos
						</a>
					</div>
				</div>
			</div>
		</div>
    </section>
@stop
