@extends('layout.layout')

@section('title') Cierre mensual @stop

@section('content')
    <section class="content-header">
		<h1>
			Cierre contable mensual<small>Administración cierres contables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			@yield('breadcrumb')
		</ol>
    </section>

	<section class="content">
    	@yield('module')
    </section>
    
    <script type="text/template" id="close-accounting-mensual-confirm-tpl">
        <p>Esta Operación afectará los saldos iniciales de los Saldos Contables. Desea Continuar?</p>
    </script>
@stop
