@extends('production.subtipoproductosp.main')

@section('breadcrumb')
    <li class="active">Subtipos de producto</li>
@stop

@section('module')
    <div id="subtipoproductosp-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="subtipoproductosp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
