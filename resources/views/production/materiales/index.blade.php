@extends('production.materiales.main')

@section('breadcrumb')
    <li class="active">Materiales</li>
@stop

@section('module')
    <div id="materialesp-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="materialesp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop