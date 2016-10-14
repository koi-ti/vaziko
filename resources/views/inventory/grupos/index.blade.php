@extends('inventory.grupos.main')

@section('breadcrumb')
    <li class="active">Grupos</li>
@stop

@section('module')
    <div id="grupos-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="grupos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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