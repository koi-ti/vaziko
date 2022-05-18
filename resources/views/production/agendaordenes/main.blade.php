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
            <div class="col-sm-3">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-schedule">
                            <tbody>
                                <tr>
                                    <th colspan="2" class="bg-gray">Ordenes de producción</th>
                                </tr>
                                <tr>
                                    <td>Abierta</td>
                                    <td>
                                        @if (auth()->user()->hasRole('admin'))
                                            <a href="#" class="export-excel">
                                                <span class="badge bg-green pull-right">{{ $schedule->op_abiertas }}</span>
                                            </a>
                                        @else
                                            <span class="badge bg-green pull-right">{{ $schedule->op_abiertas }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cerrada</td>
                                    <td><span class="badge bg-black pull-right">-</span></td>
                                </tr>
                                <tr>
                                    <td>Facturada</td>
                                    <td><span class="badge bg-gray pull-right">-</span></td>
                                </tr>
                                <tr>
                                    <td>Remisionada</td>
                                    <td><span class="badge bg-race pull-right">{{ $schedule->op_remisionadas }}</span></td>
                                </tr>
                                <tr>
                                    <td>Recogida</td>
                                    <td><span class="badge bg-light-blue pull-right">{{ $schedule->op_recogidas }}</span></td>
                                </tr>
                                <tr>
                                    <td>Incumplidas</td>
                                    <td><span class="badge bg-red pull-right">{{ $schedule->op_incumplidas }}</span></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="bg-gray">Cotizaciones</th>
                                </tr>
                                <tr>
                                    <td>Abierta</td>
                                    <td><span class="badge bg-green pull-right">{{ $schedule->co_abiertas }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
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
			<div class="col-sm-3">
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
			<div class="col-sm-3">
				<label class="control-label">F. Entrega</label>
				<div><%- orden_fecha_entrega %></div>
	        </div>
	        <div class="col-sm-3">
				<label class="control-label">H. Entrega</label>
				<div><%- orden_hora_entrega %></div>
	        </div>
		</div>

        <div class="row">
            <% if (type == 'R1') { %>
                <div class="col-sm-3">
                    <label class="control-label">F. Recogida #1</label>
                    <div><%- orden_fecha_recogida1 %></div>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">H. Recogida #1</label>
                    <div><%- orden_hora_recogida1 %></div>
                </div>
            <% } %>
            <% if (type == 'R2') { %>
                <div class="col-sm-3">
                    <label class="control-label">F. Recogida #2</label>
                    <div><%- orden_fecha_recogida2 %></div>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">H. Recogida #2</label>
                    <div><%- orden_hora_recogida2 %></div>
                </div>
            <% } %>
        </div>

		<div class="row">
			<div class="col-sm-12">
				<label class="control-label">Orden</label>
                <div>
                    <a href="<%- window.Misc.urlFull( Route.route('ordenes.show', {ordenes: orden_id}) ) %>" title="Ir a orden"><%- title %></a>
                    <br>
                    <a href="<%- window.Misc.urlFull( Route.route('tiemposp.index', {ordenp: title}) ) %>" class="btn btn-primary btn-sm" title="Agregar tiempo">Agregar tiempo de producción</a></div>
               </div>
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
