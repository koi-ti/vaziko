@extends('production.precotizaciones.main')

@section('module')
    <section class="content-header">
        <h1>
            Pre-cotizaciones <small>Administración de pre-cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Pre-cotizaciones</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-success" id="precotizaciones-main">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="searchprecotizacion_numero" class="col-md-1 control-label">Código</label>
                        <div class="col-md-2">
                            <input id="searchprecotizacion_numero" placeholder="Código" class="form-control input-sm" name="searchprecotizacion_numero" type="text" maxlength="15" value="{{ session('searchprecotizacion_numero') }}">
                        </div>

                        <label for="searchprecotizacion_estado" class="col-md-1 control-label">Estado</label>
                        <div class="col-md-2">
                            <select name="searchprecotizacion_estado" id="searchprecotizacion_estado" class="form-control">
                                <option value="" selected>Todas</option>
                                <option value="A" {{ session('searchprecotizacion_estado') == 'A' ? 'selected': '' }}>Abiertas</option>
                                <option value="C" {{ session('searchprecotizacion_estado') == 'C' ? 'selected': '' }}>Cerradas</option>
                                <option value="T" {{ session('searchprecotizacion_estado') == 'T' ? 'selected': '' }}>Culminadas</option>
                            </select>
                        </div>

                        <label for="searchprecotizacion_tercero" class="col-sm-1 control-label">Tercero</label>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchprecotizacion_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="searchprecotizacion_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchprecotizacion_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-precotizacion" data-name="searchprecotizacion_tercero_nombre" value="{{ session('searchprecotizacion_tercero') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input id="searchprecotizacion_tercero_nombre" name="searchprecotizacion_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchprecotizacion_tercero_nombre') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="searchprecotizacion_referencia" class="col-sm-1 control-label">Referencia</label>
                        <div class="col-sm-5">
                            <input id="searchprecotizacion_referencia" name="searchprecotizacion_referencia" placeholder="Referencia" class="form-control input-sm" type="text" value="{{ session('searchprecotizacion_referencia') }}">
                        </div>
                        <label for="searchprecotizacion_productop" class="col-md-1 control-label">Producto</label>
                        <div class="col-md-5">
                            <select name="searchprecotizacion_productop" id="searchprecotizacion_productop" class="form-control select2-default-clear">
                                @foreach (App\Models\Production\Productop::getProductos() as $key => $value)
                                    <option value="{{ $key }}" {{ session('searchprecotizacion_productop') == $key ? 'selected': '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-xs-12 col-sm-3 col-md-2">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-2">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
                    </div>
                {!! Form::close() !!}

                <div class="box-body table-responsive">
                    <table id="precotizaciones-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Ano</th>
                                <th>Numero</th>
                                <th>Tercero</th>
                                <th nowrap="nowrap">Fecha</th>
                                <th nowrap="nowrap">Tiempo culmino</th>
                                <th nowrap="nowrap">Estado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop
