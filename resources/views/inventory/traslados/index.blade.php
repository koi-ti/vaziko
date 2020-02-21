@extends('inventory.traslados.main')

@section('breadcrumb')
    <li class="active">Traslados</li>
@stop

@section('module')
    <div id="traslados-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="traslados-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
