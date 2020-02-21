@extends('admin.sucursal.main')

@section('breadcrumb')
    <li class="active">Sucursales</li>
@stop

@section('module')
    <div id="sucursales-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="sucursales-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
