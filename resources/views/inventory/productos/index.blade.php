@extends('inventory.productos.main')

@section('breadcrumb')
    <li class="active">Productos</li>
@stop

@section('module')
    <div id="productos-main">
        <div class="box box-success">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-producto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="producto_codigo" class="col-md-1 control-label">Código</label>
                        <div class="col-md-2">
                            {!! Form::text('producto_codigo', session('search_producto_codigo'), ['id' => 'producto_codigo', 'class' => 'form-control input-sm']) !!}
                        </div>

                        <label for="producto_nombre" class="col-md-1 control-label">Nombre</label>
                        <div class="col-md-8">
                            {!! Form::text('producto_nombre', session('search_producto_nombre'), ['id' => 'producto_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
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
                            <a href="{{ route('productos.create') }}" class="btn btn-default btn-block btn-sm">
                                <i class="fa fa-plus"></i> Nuevo
                            </a>
                        </div>
                    </div>
                {!! Form::close() !!}

                <div class="table-responsive">
                    <table id="productos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
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
@stop