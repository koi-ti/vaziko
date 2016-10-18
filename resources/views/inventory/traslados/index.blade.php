@extends('inventory.traslados.main')

@section('breadcrumb')
    <li class="active">Traslados</li>
@stop

@section('module')
    <div id="traslados-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="traslados-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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