@extends('production.areas.main')

@section('breadcrumb')
    <li class="active">Áreas</li>
@stop

@section('module')
    <div id="areasp-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="areasp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Valor</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
