@extends('admin.roles.main')

@section('breadcrumb')
    <li class="active">Roles</li>
@stop

@section('module')
    <div id="roles-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="roles-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="25%">Mostrar nombre</th>
                            <th width="25%">Nombre</th>
                            <th width="50%">Descripcion</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop