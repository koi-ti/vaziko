@extends('receivable.facturas.main')

@section('module')
    <section class="content-header">
        <h1>
            Facturas <small>Administración de facturas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Facturas</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-success" id="facturas-main">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-factura-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
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
                        <div class="col-sm-6">
                            <input id="searchfactura_tercero_nombre" name="searchfactura_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('searchfactura_tercero_nombre') }}">
                        </div>

                        <label for="searchfactura_numero" class="col-sm-1 control-label">Número</label>
                        <div class="col-sm-2">
                            <input id="searchfactura_numero" placeholder="Número" class="form-control input-sm" name="searchfactura_numero" type="text" maxlength="15" value="{{ session('searchfactura_numero') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
                        <div class="col-md-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
                        @ability ('crear' | 'facturas')
                            <div class="col-md-2 col-xs-4">
                                <a href="{{ route('facturas.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-plus"></i> Nueva
                                </a>
                            </div>
                        @endability
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="box-body table-index">
                <table id="facturas-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                    <thead>
                        <tr>
                            <th >Número</th>
                            <th >Prefijo</th>
                            <th >Nit</th>
                            <th >Cliente</th>
                            <th >Valor</th>
                            <th >Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@stop
