@extends('layout.layout')

@section('title') Tiempo ordenes de producción @stop

@section('content')
    <section class="content-header">
		<h1>
			Tiempo ordenes de producción <small>Administración tiempo ordenes de producción</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Tiempo ordenes de producción</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="tiempoordenp-create">
		 	{!! Form::open(['id' => 'form-tiempoordenp', 'data-toggle' => 'validator']) !!}
                <div class="box-body">
                    <div class="row">
                        <label for="tiempoordenp_ordenp" class="col-md-1 control-label">Orden</label>
                        <div class="form-group col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="tiempoordenp_ordenp">
                                        <i class="fa fa-building-o"></i>
                                    </button>
                                </span>
                                <input id="tiempoordenp_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="tiempoordenp_ordenp" type="text" maxlength="15" data-name="tiempoordenp_ordenp_beneficiario" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-5">
                            <input id="tiempoordenp_ordenp_beneficiario" name="tiempoordenp_ordenp_beneficiario" placeholder="Orden beneficiario" class="form-control input-sm" type="text" readonly required>
                        </div>

                        <label for="tiempoordenp_fecha" class="col-md-1 control-label">Fecha</label>
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="tiempoordenp_fecha" name="tiempoordenp_fecha" placeholder="Fecha inicio" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempoordenp_actividadop" class="control-label col-md-1">Actividad</label>
                        <div class="form-group col-md-5">
                            <select name="tiempoordenp_actividadop" id="tiempoordenp_actividadop" class="form-control select2-default-clear" required>
                                @foreach( App\Models\Production\ActividadOp::getActividadesOp() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <label for="tiempoordenp_subactividadop" class="control-label col-md-1">SubActividad</label>
                        <div class="form-group col-md-4">
                            <select name="tiempoordenp_subactividadop" id="tiempoordenp_subactividadop" class="form-control select2-default-clear" required>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempoordenp_areap" class="control-label col-md-1">Área</label>
                        <div class="form-group col-md-4">
                            <select name="tiempoordenp_areap" id="tiempoordenp_areap" class="form-control select2-default-clear" required>
                                @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <label for="tiempoordenp_hora_inicio" class="col-md-1 control-label">H. inicio</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempoordenp_hora_inicio" name="tiempoordenp_hora_inicio" placeholder="Inicio" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <label for="tiempoordenp_hora_fin" class="col-md-1 control-label">H. fin</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempoordenp_hora_fin" name="tiempoordenp_hora_fin" placeholder="Fin" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

    			<div class="box-header with-border">
    	        	<div class="row">
    					<div class="col-md-2 col-md-offset-5 col-sm-12 col-xs-6 text-right">
    						<button type="button" class="btn btn-primary btn-sm btn-block submit-tiempoordenp">{{ trans('app.add') }}</button>
    					</div>
    				</div>
    			</div>

                <div id="render-form-tiempoordenp"></div>
			{!! Form::close() !!}
		</div>
	</section>

    <script type="text/template" id="add-tiempoordenp-tpl">
        <div class="box-body">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Informacion adicional del sr(a) <b>{{ Auth::user()->getName() }}</b></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th width="20%">Orden</th>
                                    <th width="20%">Actividad</th>
                                    <th width="20%">Subactividad</th>
                                    <th width="20%">Área</th>
                                    <th width="10%">Fecha</th>
                                    <th width="5%">Hora inicio</th>
                                    <th width="5%">Hora fin</th>
                                    <th width="2%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <% if(tiempos.length) { %>
                                    <% _.each(tiempos, function(item) { %>
                                        <tr>
                                            <td><b><%- item.orden_codigo %></b> <%- item.tercero_nombre %></td>
                                            <td><%- item.actividadop_nombre %></td>
                                            <td><%- item.subactividadop_nombre %></td>
                                            <td><%- item.areap_nombre %></td>
                                            <td><%- item.tiempoordenp_fecha %></td>
                                            <td><%- moment(item.tiempoordenp_hora_inicio, 'HH:mm').format('HH:mm') %></td>
                                            <td><%- moment(item.tiempoordenp_hora_fin, 'HH:mm').format('HH:mm') %></td>
                                            <td class="text-center">
                                                <a class="btn btn-default btn-xs btn-edit-tiempoordenp" data-id="<%- item.id %>">
                                                    <span><i class="fa fa-pencil-square-o"></i></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <% }); %>
                                <% }else{ %>
                                    <tr>
                                        <th colspan="6" class="text-center">No existen items para el cliente.</th>
                                    </tr>
                                <% } %>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </script>
@stop
