@extends('inventory.traslados.main')

@section('breadcrumb')
    <li><a href="{{ route('traslados.index')}}">Traslados</a></li>
    <li class="active">{{ $traslado->traslado1_numero }}</li>
@stop

@section('module')
    <div class="box box-success" id="traslados-show">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('traslados.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $traslado->origen }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Número</label>
                    <div>{{ $traslado->traslado1_numero }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Destino</label>
                    <div>{{ $traslado->destino }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $traslado->traslado1_fecha }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Detalle</label>
                    <div>{{ $traslado->traslado1_observaciones }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Usuario elaboro</label>
                    <div>
                        <a href="{{ route('terceros.show', ['terceros' =>  $traslado->traslado1_usuario_elaboro ]) }}" title="Ver tercero">
                            {{ $traslado->username_elaboro }}</a>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha elaboro</label>
                    <div>{{ $traslado->traslado1_fecha_elaboro }}</div>
                </div>
            </div>

            <div class="box-body table-responsive">
                <table id="browse-detalle-traslado-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Unidades</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop