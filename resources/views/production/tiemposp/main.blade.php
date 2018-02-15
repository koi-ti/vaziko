@extends('layout.layout')

@section('title') Tiempos de producción @stop

@section('content')
    <section class="content-header">
		<h1>
			Tiempos de producción <small>Administración tiempos de producción</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Tiempos de producción</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="tiempop-create">
		 	{!! Form::open(['id' => 'form-tiempop', 'data-toggle' => 'validator']) !!}
                <div class="box-body">
                    <div class="row">
                        <label for="tiempop_ordenp" class="col-md-1 control-label">Orden</label>
                        <div class="form-group col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="tiempop_ordenp">
                                        <i class="fa fa-building-o"></i>
                                    </button>
                                </span>
                                <input id="tiempop_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="tiempop_ordenp" type="text" maxlength="15" data-estado="A" data-name="tiempop_ordenp_beneficiario">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <input id="tiempop_ordenp_beneficiario" name="tiempop_ordenp_beneficiario" placeholder="Orden beneficiario" class="form-control input-sm" type="text" readonly>
                        </div>

                        <label for="tiempop_fecha" class="col-md-1 control-label">Fecha</label>
                        <div class="form-group col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="tiempop_fecha" name="tiempop_fecha" placeholder="Fecha inicio" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempop_actividadp" class="control-label col-md-1">Actividad</label>
                        <div class="form-group col-md-5">
                            <select name="tiempop_actividadp" id="tiempop_actividadp" class="form-control select2-default-clear" required>
                                @foreach( App\Models\Production\Actividadp::getActividadesp() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>

                        <label for="tiempop_subactividadp" class="control-label col-md-1">Subactividad</label>
                        <div class="form-group col-md-4">
                            <select name="tiempop_subactividadp" id="tiempop_subactividadp" class="form-control select2-default-clear" required>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempop_areap" class="control-label col-md-1">Área</label>
                        <div class="form-group col-md-4">
                            <select name="tiempop_areap" id="tiempop_areap" class="form-control select2-default-clear" required>
                                @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                        <label for="tiempop_hora_inicio" class="col-md-1 control-label">H. inicio</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempop_hora_inicio" name="tiempop_hora_inicio" placeholder="Inicio" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <label for="tiempop_hora_fin" class="col-md-1 control-label">H. fin</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempop_hora_fin" name="tiempop_hora_fin" placeholder="Fin" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                @if( Auth::user()->ability('admin', 'crear', ['module' => 'tiemposp']) )
        			<div class="box-header with-border">
        	        	<div class="row">
        					<div class="col-md-2 col-md-offset-5 col-sm-12 col-xs-6 text-right">
        						<button type="button" class="btn btn-primary btn-sm btn-block submit-tiempop">{{ trans('app.add') }}</button>
        					</div>
        				</div>
        			</div>
                @endif
            {!! Form::close() !!}

            <div class="box-body">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información adicional del sr(a) <b>{{ Auth::user()->getUsername() }}</b></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table id="browse-tiemposp-global-list" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="2%">#</th>
                                    <th width="20%">Orden</th>
                                    <th width="20%">Actividad</th>
                                    <th width="20%">Subactividad</th>
                                    <th width="20%">Área</th>
                                    <th width="8%">Fecha</th>
                                    <th width="5%">H. inicio</th>
                                    <th width="5%">H. fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Render content --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
	</section>

    <script type="text/template" id="tiempop-item-list-tpl">
        <td><%- id %></td>
        <td><%- ( !_.isNull(orden_codigo) && !_.isNull(tercero_nombre)) ? orden_codigo+' - '+tercero_nombre : '-' %></td>
        <td><%- actividadp_nombre %></td>
        <td><%- !_.isNull(subactividadp_nombre) ? subactividadp_nombre : ' - ' %></td>
        <td><%- areap_nombre %></td>
        <td><%- tiempop_fecha %></td>
        <td><%- moment(tiempop_hora_inicio, 'HH:mm').format('HH:mm') %></td>
        <td><%- moment(tiempop_hora_fin, 'H:mm').format('H:mm') %></td>
        @if( Auth::user()->ability('admin', 'editar', ['module' => 'tiemposp']) )
            <td class="text-center">
                <a class="btn btn-default btn-xs edit-tiempop" data-tiempo-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        @endif
    </script>

    <script type="text/template" id="edit-tiempop-tpl">
    	<div class="row">
    		<input type="hidden" id="tiempop_id" value="<%- id %>">
    		<label for="tiempop_fecha" class="col-md-1 control-label">Fecha</label>
    		<div class="form-group col-md-4">
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-calendar"></i>
    				</div>
    				<input type="text" id="tiempop_fecha" name="tiempop_fecha" placeholder="Fecha inicio" value="<%- tiempop_fecha %>" class="form-control input-sm datepicker" required>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>
    	</div>

    	<div class="row">
    		<label for="tiempop_hora_inicio" class="col-md-1 control-label">H. inicio</label>
    		<div class="form-group col-md-4">
    			<div class="bootstrap-timepicker">
    				<div class="input-group">
    					<input type="text" id="tiempop_hora_inicio" name="tiempop_hora_inicio" placeholder="Inicio" value="<%- tiempop_hora_inicio %>" class="form-control input-sm timepicker" required>
    					<div class="input-group-addon">
    						<i class="fa fa-clock-o"></i>
    					</div>
    				</div>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>
    		<label for="tiempop_hora_fin" class="col-md-1 control-label">H. fin</label>
    		<div class="form-group col-md-4">
    			<div class="bootstrap-timepicker">
    				<div class="input-group">
    					<input type="text" id="tiempop_hora_fin" name="tiempop_hora_fin" placeholder="Fin" value="<%- tiempop_hora_fin %>" class="form-control input-sm timepicker" required>
    					<div class="input-group-addon">
    						<i class="fa fa-clock-o"></i>
    					</div>
    				</div>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>
    	</div>
    </script>
@stop
