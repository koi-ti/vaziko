@extends('inventory.subgrupos.main')

@section('breadcrumb')
    <li class="active">Subgrupos</li>
@stop

@section('module')
    <div id="subgrupos-main" class="box box-success">
        <div class="box-body table-responsive">
            <table id="subgrupos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
