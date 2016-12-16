@extends('layout.layout')

@section('title') Productos @stop

@section('content')
    <section class="content-header">
        <h1>
            Productos <small>Administración de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-productop-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-productosp" data-toggle="validator">
            <div class="box-body">
                <div class="row">
                    <label for="productop_nombre" class="col-sm-1 control-label">Nombre</label>
                    <div class="form-group col-sm-11">
                        <input type="text" id="productop_nombre" name="productop_nombre" value="<%- productop_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="250" required>
                    </div>
                </div>

                <div class="row">
                    <label for="productop_observaciones" class="col-sm-1 control-label">Detalle</label>
                    <div class="form-group col-sm-10">
                        <textarea id="productop_observaciones" name="productop_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- productop_observaciones %></textarea>
                    </div>
                </div>

                <div class="row">
                    <label for="productop_abierto" class="col-sm-1 control-label">Abierto</label>
                    <div class="form-group col-md-1">
                        <input type="checkbox" id="productop_abierto" name="productop_abierto" value="productop_abierto" <%- productop_abierto ? 'checked': ''%>>
                    </div>

                    <label for="productop_ancho_med" class="col-sm-1 control-label">Ancho</label>
                    <div class="form-group col-md-2">
                        <select name="productop_ancho_med" id="productop_ancho_med" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_ancho_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="productop_alto_med" class="col-sm-1 control-label">Alto</label>
                    <div class="form-group col-md-2">
                        <select name="productop_alto_med" id="productop_alto_med" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_alto_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <label for="productop_cerrado" class="col-sm-1 control-label">Cerrado</label>
                    <div class="form-group col-md-1">
                        <input type="checkbox" id="productop_cerrado" name="productop_cerrado" value="productop_cerrado" <%- productop_cerrado ? 'checked': ''%>>
                    </div>

                    <label for="productop_c_med_ancho" class="col-sm-1 control-label">Ancho</label>
                    <div class="form-group col-md-2">
                        <select name="productop_c_med_ancho" id="productop_c_med_ancho" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_c_med_ancho == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="productop_c_med_alto" class="col-sm-1 control-label">Alto</label>
                    <div class="form-group col-md-2">
                        <select name="productop_c_med_alto" id="productop_c_med_alto" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_c_med_alto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <label for="productop_3d" class="col-sm-1 control-label">3D</label>
                    <div class="form-group col-md-1">
                        <input type="checkbox" id="productop_3d" name="productop_3d" value="productop_3d" <%- productop_3d ? 'checked': ''%>>
                    </div>

                    <label for="productop_3d_ancho_med" class="col-sm-1 control-label">Ancho</label>
                    <div class="form-group col-md-2">
                        <select name="productop_3d_ancho_med" id="productop_3d_ancho_med" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_3d_ancho_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="productop_3d_alto_med" class="col-sm-1 control-label">Alto</label>
                    <div class="form-group col-md-2">
                        <select name="productop_3d_alto_med" id="productop_3d_alto_med" class="form-control">
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                <option value="{{ $key }}" <%- productop_3d_alto_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <label for="productop_tiro" class="col-sm-1 control-label">Tiro</label>
                    <div class="form-group col-md-1">
                        <input type="checkbox" id="productop_tiro" name="productop_tiro" value="productop_tiro" <%- productop_tiro ? 'checked': ''%>>
                    </div>

                    <label for="productop_retiro" class="col-sm-1 control-label">Retiro</label>
                    <div class="form-group col-md-1">
                        <input type="checkbox" id="productop_retiro" name="productop_retiro" value="productop_retiro" <%- productop_retiro ? 'checked': ''%>>
                    </div>
                </div>
            </div>

            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                        <a href="{{ route('productosp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
                    <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </script>
@stop