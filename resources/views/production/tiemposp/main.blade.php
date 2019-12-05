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

    <section class="content" id="tiemposp-main">
        @yield('module')
    </section>

   	<script type="text/template" id="add-tiempop-tpl">
        @if(auth()->user()->ability('admin', 'crear', ['module' => 'tiemposp']))
    	    <div id="tiempop-main" class="box box-success spinner-main">
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
                                    <input id="tiempop_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="tiempop_ordenp" type="text" maxlength="15" data-name="tiempop_ordenp_beneficiario" data-estado="AT">
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
                                <select name="tiempop_subactividadp" id="tiempop_subactividadp" class="form-control select2-default-clear" required></select>
                                <div class="help-block with-errors"></div>
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
                                <div class="input-group clockpicker">
                                    <input type="text" id="tiempop_hora_inicio" name="tiempop_hora_inicio" class="form-control" value="{{ date('H:i') }}" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <label for="tiempop_hora_fin" class="col-md-1 control-label">H. fin</label>
                            <div class="form-group col-md-2">
                                <div class="input-group clockpicker">
                                    <input type="text" id="tiempop_hora_fin" name="tiempop_hora_fin" placeholder="Fin" class="form-control" value="{{ date('H:i') }}" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
        			<div class="box-header with-border">
        	        	<div class="row">
        					<div class="col-md-2 col-md-offset-5 col-sm-12 col-xs-6 text-right">
        						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.add') }}</button>
        					</div>
        				</div>
        			</div>
                {!! Form::close() !!}
            </div>
        @endif

        <div class="box box-success spinner-main">
            <div class="box-header with-border">
                <h3 class="box-title">Información adicional del sr(a) <b>{{ auth()->user()->getUsername() }}</b></h3>
            </div>

            <div class="box-body">
                <table id="browse-tiemposp-global-list" class="table table-bordered table-responsive no-padding" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="3%">#</th>
                            <th width="61%">Área</th>
                            <th width="10%">Fecha</th>
                            <th width="10%">H. inicio</th>
                            <th width="10%">H. fin</th>
                            <th width="9%" colspan="3">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
		</div>
	</script>

    <script type="text/template" id="tiempop-item-list-tpl">
        <tr>
            <td><%- id %></td>
            <td><%- areap_nombre %></td>
            <td><%- tiempop_fecha %></td>
            <td><%- moment(tiempop_hora_inicio, 'HH:mm').format('HH:mm') %></td>
            <td><%- moment(tiempop_hora_fin, 'H:mm').format('H:mm') %></td>
            @if (auth()->user()->ability('admin', 'editar', ['module' => 'tiemposp']))
                <td class="text-center">
                    <a class="btn btn-default btn-xs item-edit" data-resource="<%- id %>">
                        <span><i class="fa fa-pencil-square-o"></i></span>
                    </a>
                </td>
            @endif
            <td class="text-center">
                <a class="btn btn-success btn-xs item-show" data-toggle="collapse" href="#collapse_<%- id %>">
                    <span><i class="fa fa-eye"></i></span>
                </a>
            </td>
        </tr>
        <tr id="collapse_<%- id %>" class="collapse">
            <td colspan="8">
                <div>
                    <p class="text-muted"><b>Orden de producción:</b> <%- ( !_.isNull(orden_codigo) && !_.isNull(tercero_nombre)) ? orden_codigo+' - '+tercero_nombre : '-' %></p>
                    <p class="text-muted"><b>Actividad de producción:</b> <%- actividadp_nombre %></p>
                    <p class="text-muted"><b>Subactividad de producción:</b> <%- !_.isNull(subactividadp_nombre) ? subactividadp_nombre : ' - ' %></p>
                </div>
            </td>
        </tr>
    </script>

    <script type="text/template" id="edit-tiempop-tpl">
        <div class="row">
            <label for="tiemposp_ordenp" class="col-md-1 control-label">Orden</label>
            <div class="form-group col-md-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="tiemposp_ordenp">
                            <i class="fa fa-building-o"></i>
                        </button>
                    </span>
                    <input id="tiemposp_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="tiemposp_ordenp" type="text" maxlength="15" data-estado="AT" data-name="tiemposp_ordenp_beneficiario" value="<%- orden_codigo %>">
                </div>
            </div>
            <div class="col-md-9">
                <input id="tiemposp_ordenp_beneficiario" name="tiempop_ordenp_beneficiario" placeholder="Orden beneficiario" class="form-control input-sm" type="text" value="<%- tercero_nombre %>" readonly>
            </div>
        </div>
    	<div class="row">
    		<label for="tiempop_fecha" class="col-md-1 control-label">Fecha</label>
    		<div class="form-group col-md-3">
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-calendar"></i>
    				</div>
    				<input type="text" id="tiempop_fecha" name="tiempop_fecha" placeholder="Fecha inicio" value="<%- tiempop_fecha %>" class="form-control input-sm datepicker" required>
    			</div>
    			<div class="help-block with-errors"></div>
    		</div>
            <label for="tiempop_hora_inicio" class="col-md-1 control-label">H. inicio</label>
            <div class="form-group col-md-2">
                <div class="input-group clockpicker">
                    <input type="text" id="tiempop_hora_inicio" name="tiempop_hora_inicio" class="form-control" value="<%- moment(tiempop_hora_inicio, 'H:mm:ss').format('H:mm') %>" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <label for="tiempop_hora_fin" class="col-md-1 control-label">H. fin</label>
            <div class="form-group col-md-2">
                <div class="input-group clockpicker">
                    <input type="text" id="tiempop_hora_fin" name="tiempop_hora_fin" placeholder="Fin" class="form-control" value="<%- moment(tiempop_hora_fin, 'H:mm:ss').format('H:mm') %>" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                <div class="help-block with-errors"></div>
            </div>
    	</div>
    </script>
@stop
