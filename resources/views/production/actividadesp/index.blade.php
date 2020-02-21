@extends('production.actividadesp.main')

@section('breadcrumb')
    <li class="active">Actividades de producción</li>
@stop

@section('module')
    <div id="actividadesp-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="actividadesp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
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
@stop
