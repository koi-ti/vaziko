@extends('receivable.facturas.main')

@section('breadcrumb')
    <li class="active">Facturas</li>
@stop

@section('module')
    <div id="facturas-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                {!! Form::open(['id' => 'form-koi-search-factura-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="row">
                        <label for="searchfactura_tercero" class="col-sm-1 control-label">Tercero</label>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchfactura_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="searchfactura_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchfactura_tercero" type="text" maxlength="15" data-name="searchfactura_tercero_nombre" value="{{ session('searchfactura_tercero') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input id="searchfactura_tercero_nombre" name="searchfactura_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchfactura_tercero_nombre') }}">
                        </div>


                        <label for="searchfactura_ordenp" class="col-sm-1 control-label">Orden</label>
                        <div class="col-sm-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="searchfactura_ordenp">
                                        <i class="fa fa-building-o"></i>
                                    </button>
                                </span>
                                <input id="searchfactura_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="searchfactura_ordenp" type="text" maxlength="15" data-name="searchfactura_ordenp_beneficiario" required value="{{ session('searchfactura_ordenp_beneficiario') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input id="searchfactura_ordenp_beneficiario" name="searchfactura_ordenp_beneficiario" placeholder="Tercero" class="form-control input-sm" type="text" readonly required value="{{ session('searchfactura_ordenp_beneficiario') }}">
                        </div>
                    </div>

                    <div class="row"><br>
                        <label for="searchfactura_numero" class="col-sm-1 control-label">Numero</label>
                        <div class="col-sm-2">
                            <input id="searchfactura_numero" placeholder="Numero" class="form-control input-sm" name="searchfactura_numero" type="text" maxlength="15" value="{{ session('searchfactura_numero') }}">
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

                <table id="facturas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th >Numero</th>
                            <th >Nit</th>
                            <th >Cliente</th>
                            <th >Orden</th>
                            <th >Prefijo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop