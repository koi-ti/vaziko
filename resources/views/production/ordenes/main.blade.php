@extends('layout.layout')

@section('title') Ordenes de producción @stop

@section('content')
    <section class="content-header">
        <h1>
            Ordenes de producción <small>Administración de ordenes de producción</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-ordenp-tpl">
        <div class="row">
            <label for="orden_referencia" class="col-sm-1 control-label">Referencia</label>
            <div class="form-group col-md-8">
                <input id="orden_referencia" value="<%- orden_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" name="orden_referencia" type="text" maxlength="200" required>
            </div>
        </div>

        <div class="row">
            <label for="orden_fecha_inicio" class="col-sm-1 control-label">F. Inicio</label>
            <div class="form-group col-md-2">
                <input type="text" id="orden_fecha_inicio" name="orden_fecha_inicio" placeholder="Fecha inicio" class="form-control input-sm datepicker" value="<%- orden_fecha_inicio %>" required>
            </div>

            <label for="orden_fecha_entrega" class="col-sm-1 control-label">F. Entrega</label>
            <div class="form-group col-md-2">
                <input type="text" id="orden_fecha_entrega" name="orden_fecha_entrega" placeholder="Fecha entrega" class="form-control input-sm datepicker" value="<%- orden_fecha_entrega %>" required>
            </div>

            <label for="orden_hora_entrega" class="col-sm-1 control-label">H. Entrega</label>
            <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <div class="input-group">
                        <input type="text" id="orden_hora_entrega" name="orden_hora_entrega" placeholder="Fecha entrega" class="form-control input-sm timepicker" value="<%- orden_hora_entrega %>" required>
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <label for="orden_cliente" class="col-sm-1 control-label">Cliente</label>
            <div class="form-group col-sm-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="orden_cliente">
                            <i class="fa fa-user"></i>
                        </button>
                    </span>
                    <input id="orden_cliente" placeholder="Cliente" class="form-control tercero-koi-component" name="orden_cliente" type="text" maxlength="15" data-wrapper="ordenes-create" data-name="orden_cliente_nombre" value="<%- tercero_nit %>" required>
                </div>
            </div>
            <div class="col-sm-5">
                <input id="orden_cliente_nombre" name="orden_cliente_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
            </div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tercero" data-field="orden_cliente">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <label for="orden_observaciones" class="col-sm-1 control-label">Detalle</label>
            <div class="form-group col-sm-10">
                <textarea id="orden_observaciones" name="orden_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- orden_observaciones %></textarea>
            </div>
        </div>

        <div class="row">
            <label for="orden_terminado" class="col-sm-1 control-label">Terminado</label>
            <div class="form-group col-sm-10">
                <textarea id="orden_terminado" name="orden_terminado" class="form-control" rows="2" placeholder="Terminado"><%- orden_terminado %></textarea>
            </div>
        </div>
    </script>
@stop