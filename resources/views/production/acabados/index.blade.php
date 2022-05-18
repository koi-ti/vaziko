@extends('production.acabados.main')

@section('breadcrumb')
    <li class="active">Acabados</li>
@stop

@section('module')
    <div id="acabadosp-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="acabadosp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
