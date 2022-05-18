@extends('admin.roles.main')

@section('module')
    <section class="content-header">
        <h1>
            Roles <small>Administración de roles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Roles</li>
        </ol>
    </section>

    <section class="content">
        <div id="roles-main" class="box box-success">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="roles-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
                        <thead>
                            <tr>
                                <th width="30%">Nombre</th>
                                <th width="70%">Descripcion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop
