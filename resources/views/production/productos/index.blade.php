@extends('production.productos.main')

@section('module')

    <section class="content-header">
        <h1>
            Productos <small>Administración de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            <li class="active">Productos</li>
        </ol>
    </section>

    <section class="content">
        <div id="productosp-main">
            <div class="box box-success">
                <div class="box-body">
                    {!! Form::open(['id' => 'form-koi-search-producto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="productop_codigo" class="col-md-1 control-label">Código</label>
                            <div class="col-md-2">
                                {!! Form::text('productop_codigo', session('search_productop_codigo'), ['id' => 'productop_codigo', 'class' => 'form-control input-sm']) !!}
                            </div>

                            <label for="productop_nombre" class="col-md-1 control-label">Nombre</label>
                            <div class="col-md-8">
                                {!! Form::text('productop_nombre', session('search_productop_nombre'), ['id' => 'productop_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-2 col-xs-4">
                                <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <a href="{{ route('productosp.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-plus"></i> Nuevo producto
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="table-responsive">
                        <table id="productosp-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
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
        </div>
    </section>
@stop
