@extends('treasury.facturasp.main')

@section('breadcrumb')
    <li class="active">Facturas proveedor</li>
@stop

@section('module')
    <div id="facturasp-main">
        <div class="box box-success">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-facturap-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="searchfacturap_tercero" class="col-sm-1 control-label">Tercero</label>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchfacturap_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="searchfacturap_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchfacturap_tercero" type="text" maxlength="15" data-name="searchfacturap_tercero_nombre" value="{{ session('searchfacturap_tercero') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input id="searchfacturap_tercero_nombre" name="searchfacturap_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchfacturap_tercero_nombre') }}">
                        </div>

                        <label for="searchfacturap_facturap" class="col-sm-1 control-label">Factura</label>
                        <div class="col-sm-2">
                            <input id="searchfacturap_facturap" placeholder="Factura proveedor" class="form-control input-sm" name="searchfacturap_facturap" type="text" maxlength="15" value="{{ session('searchfacturap_facturap') }}">
                        </div>

                        <label for="searchfacturap_fecha" class="col-sm-1 control-label">Fecha</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="searchfacturap_fecha" placeholder="Fecha" class="form-control input-sm datepicker" name="searchfacturap_fecha" type="text" value="{{ session('searchfacturap_fecha') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="box-body table-index">
                <table id="facturasp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                    <thead>
                        <tr>
                            <th >Código</th>
                            <th >Cliente</th>
                            <th >Sucursal</th>
                            <th >Factura</th>
                            <th >Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
