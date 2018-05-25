@extends('admin.puntosventa.main')

@section('breadcrumb')
    <li class="active">Puntos de venta</li>
@stop

@section('module')
    <div id="puntosventa-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="puntosventa-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Resolución de facturación DIAN</th>
                            <th>Consecutivo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
