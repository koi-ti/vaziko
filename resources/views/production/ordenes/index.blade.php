@extends('production.ordenes.main')


@section('module')
    <section class="content-header">
        <h1>
            Ordenes de producción <small>Administración de ordenes de producción</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Ordenes de producción</li>
        </ol>
    </section>

    <section class="content">
        <div id="ordenes-main">
            <div class="box box-success">
                <div class="box-body">

                    {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="searchordenp_ordenp_numero" class="col-md-1 control-label">Código</label>
                            <div class="col-md-2">
                                <input id="searchordenp_ordenp_numero" placeholder="Código" class="form-control input-sm" name="searchordenp_ordenp_numero" type="text" maxlength="15" value="{{ session('searchordenp_ordenp_numero') }}">
                            </div>

                            <label for="searchordenp_ordenp_estado" class="col-md-1 control-label">Estado</label>
                            <div class="col-md-2">
                                <select name="searchordenp_ordenp_estado" id="searchordenp_ordenp_estado" class="form-control">
                                    <option value="" selected>Todas</option>
                                    <option value="A" {{ session('searchordenp_ordenp_estado') == 'A' ? 'selected': '' }}>Abiertas</option>
                                    <option value="N" {{ session('searchordenp_ordenp_estado') == 'N' ? 'selected': '' }}>Anuladas</option>
                                    <option value="C" {{ session('searchordenp_ordenp_estado') == 'C' ? 'selected': '' }}>Cerradas</option>
                                </select>
                            </div>

                            <label for="searchordenp_tercero" class="col-sm-1 control-label">Tercero</label>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchordenp_tercero">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="searchordenp_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchordenp_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-ordenp" data-name="searchordenp_tercero_nombre" value="{{ session('searchordenp_tercero') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input id="searchordenp_tercero_nombre" name="searchordenp_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchordenp_tercero_nombre') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="searchordenp_ordenp_referencia" class="col-md-1 control-label">Referencia</label>
                            <div class="col-md-5">
                                <input id="searchordenp_ordenp_referencia" placeholder="Referencia" class="form-control input-sm input-toupper" name="searchordenp_ordenp_referencia" type="text" maxlength="200" value="{{ session('searchordenp_ordenp_referencia') }}">
                            </div>

                            <label for="searchordenp_ordenp_productop" class="col-md-1 control-label">Producto</label>
                            <div class="col-md-5">
                                <select name="searchordenp_ordenp_productop" id="searchordenp_ordenp_productop" class="form-control select2-default-clear">
                                    @foreach( App\Models\Production\Productop::getProductos() as $key => $value)
                                        <option value="{{ $key }}" {{ session('searchordenp_ordenp_productop') == $key ? 'selected': '' }}>{{ $value }}</option>
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
                                <a href="{{ route('ordenes.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-building-o"></i> Nueva orden
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="box-body table-responsive">
                        <table id="ordenes-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Ano</th>
                                    <th>Numero</th>
                                    <th nowrap="nowrap">F. Inicio</th>
                                    <th nowrap="nowrap">F. Entrega</th>
                                    <th nowrap="nowrap">H. Entrega</th>
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
