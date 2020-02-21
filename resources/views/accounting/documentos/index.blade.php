@extends('accounting.documentos.main')

@section('breadcrumb')
    <li class="active">Documentos</li>
@stop

@section('module')
    <div id="documentos-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="documentos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Folder</th>
                        <th>Normal</th>
                        <th>Nif</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
