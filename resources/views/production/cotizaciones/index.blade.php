@extends('production.cotizaciones.main')

@section('module')
    <section class="content-header">
        <h1>
            Cotizaciones <small>Administración de cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Cotizaciones</li>
        </ol>
    </section>

    <section class="content">
        <div id="cotizaciones-main">
            <div class="box box-success">
                <div class="box-body">

                    {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="searchcotizacion_numero" class="col-md-1 control-label">Código</label>
                            <div class="col-md-2">
                                <input id="searchcotizacion_numero" placeholder="Código" class="form-control input-sm" name="searchcotizacion_numero" type="text" maxlength="15" value="{{ session('searchcotizacion_numero') }}">
                            </div>

                            <label for="searchcotizacion_estado" class="col-md-1 control-label">Estado</label>
                            <div class="col-md-2">
                                <select name="searchcotizacion_estado" id="searchcotizacion_estado" class="form-control">
                                    <option value="" selected>Todas</option>
                                    <option value="A" {{ session('searchcotizacion_estado') == 'A' ? 'selected': '' }}>Abiertas</option>
                                    <option value="N" {{ session('searchcotizacion_estado') == 'N' ? 'selected': '' }}>Anuladas</option>
                                    <option value="C" {{ session('searchcotizacion_estado') == 'C' ? 'selected': '' }}>Cerradas</option>
                                </select>
                            </div>

                            <label for="searchcotizacion_tercero" class="col-sm-1 control-label">Tercero</label>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchcotizacion_tercero">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="searchcotizacion_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchcotizacion_tercero" type="text" maxlength="15" data-wrapper="cotizaciones-main" data-name="searchcotizacion_tercero_nombre" value="{{ session('searchcotizacion_tercero') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input id="searchcotizacion_tercero_nombre" name="searchcotizacion_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchcotizacion_tercero_nombre') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="searchcotizacion_referencia" class="col-md-1 control-label">Referencia</label>
                            <div class="col-md-5">
                                <input id="searchcotizacion_referencia" placeholder="Referencia" class="form-control input-sm input-toupper" name="searchcotizacion_referencia" type="text" maxlength="200" value="{{ session('searchcotizacion_referencia') }}">
                            </div>

                            <label for="searchcotizacion_productop" class="col-md-1 control-label">Producto</label>
                            <div class="col-md-5">
                                <select name="searchcotizacion_productop" id="searchcotizacion_productop" class="form-control select2-default-clear">
                                    @foreach( App\Models\Production\Productop::getProductos() as $key => $value)
                                        <option value="{{ $key }}" {{ session('searchcotizacion_productop') == $key ? 'selected': '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-2 col-xs-4">
                                <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <a href="{{ route('cotizaciones.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-plus"></i> Nuevo
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="box-body table-responsive">
                        <table id="cotizaciones-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Ano</th>
                                    <th>Numero</th>
                                    <th nowrap="nowrap">F. Inicio</th>
                                    <th>Tercero</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
