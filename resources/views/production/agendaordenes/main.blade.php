@extends('layout.layout')

@section('title') Agenda @stop

@section('content')
   	<section class="content-header">
        <h1>Agenda</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
          	<li>Agenda</li>
        </ol>
    </section>

    <section class="content" id="agendaordenes-main">
        <div class="row">
		   	<div class="col-sm-8 col-sm-offset-2">
		        <div class="box box-solid" id="spinner-calendar">
		        	<div class="box-body">
		                <div id="calendar"></div>
		            </div>
		        </div>
		   	</div>
        </div>
    </section>

	<script type="text/template" id="add-info-event-tpl">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Estado</label>
                <% if ( orden_anulada ) { %>
                    <div><span class="label label-danger">ANULADA</span></div>

                <% }else if( orden_culminada ) { %>
                    <div><span class="label bg-blue">CULMINADO</span></div>

                <% }else if( orden_abierta ) { %>
                    <div><span class="label label-success">ABIERTA</span></div>

                <% }else{ %>
                    <div><span class="label label-warning">CERRADA</span></div>

                <% } %>
	        </div>
			<div class="col-sm-4">
				<label class="control-label">F. Entrega</label>
				<div><%- orden_fecha_entrega %></div>
	        </div>
	        <div class="col-sm-4">
				<label class="control-label">H. Entrega</label>
				<div><%- orden_hora_entrega %></div>
	        </div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label">Orden</label>
                <div><a href="<%- window.Misc.urlFull( Route.route('ordenes.show', {ordenes: orden_id}) ) %>" title="Ir a orden"><b><%- title %></b></a> - <%- orden_referencia %></div>
	        </div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label">Cliente</label>
				<div><a href="<%- window.Misc.urlFull( Route.route('terceros.show', {terceros: orden_cliente}) ) %>" title="Ir a cliente"><b><%- tercero_nit %></b></a> - <%- tercero_nombre %></div>
	        </div>
		</div>
	</script>
@stop
