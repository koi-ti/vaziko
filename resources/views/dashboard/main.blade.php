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
		<div class="row">
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Terceros</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
					<a href="{{ route('terceros.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>

		<h2 class="page-header">Inventario</h2>
		<div class="row">
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Insumos</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-wrench"></i>
					</div>
					<a href="{{ route('productos.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>

		<h2 class="page-header">Producción</h2>
		<div class="row">
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Pre-cotizaciones</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-envelope-open-o"></i>
					</div>
					<a href="{{ route('precotizaciones.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Cotizaciones</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-envelope-o"></i>
					</div>
					<a href="{{ route('cotizaciones.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Ordenes</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-building-o"></i>
					</div>
					<a href="{{ route('ordenes.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>Tiempos</h3>
						<p>&nbsp;</p>
					</div>
					<div class="icon">
						<i class="fa fa-clock-o"></i>
					</div>
					<a href="{{ route('tiemposp.index') }}" class="small-box-footer">
						Más información <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div>
		</div>
    </section>
@stop
