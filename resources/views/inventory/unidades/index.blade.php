@extends('inventory.unidades.main')

@section('breadcrumb')
    <li class="active">Unidades</li>
@stop

@section('module')
    <div id="unidades-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="unidades-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
                    <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
