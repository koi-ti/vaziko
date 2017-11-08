@extends('layout.layout')

@section('title') Terceros @stop

@section('content')
    <section class="content-header">
		<h1>
			Terceros <small>Administración de terceros</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			@yield('breadcrumb')
		</ol>
    </section>

	<section class="content">
    	@yield('module')
    </section>

    <script type="text/template" id="add-tercero-cartera-tpl">
		<td><%- factura1_numero %></td>
	    <td><%- puntoventa_prefijo %></td>
	    <td><%- factura4_cuota %></td>
	    <td><%- factura1_fecha %></td>
		<td><%- factura4_vencimiento %></td>
		<td><%- days %></td>
	    <td class="text-right"><%- window.Misc.currency(factura4_saldo) %></td>
	</script>
@stop
