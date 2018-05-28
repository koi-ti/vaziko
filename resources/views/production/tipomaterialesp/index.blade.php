@extends('production.tipomaterialesp.main')

@section('breadcrumb')
    <li class="active">Tipos de material</li>
@stop

@section('module')
    <div id="tipomaterialesp-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="tipomaterialesp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
