@extends('production.subactividadesop.main')

@section('breadcrumb')
    <li class="active">SubActividades de producción</li>
@stop

@section('module')
    <div id="subactividadesop-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="subactividadesop-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
    </div>
@stop
