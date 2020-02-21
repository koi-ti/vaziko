@extends('production.subactividadesp.main')

@section('breadcrumb')
    <li class="active">Subactividades de producción</li>
@stop

@section('module')
    <div id="subactividadesp-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="subactividadesp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Actividad</th>
                        <th>Nombre</th>
                        <th>Activo</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
