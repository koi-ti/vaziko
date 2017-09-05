@extends('production.productos.main')

@section('module')
    <section class="content-header">
        <h1>
            Productos <small>Administración de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            <li><a href="{{ route('productosp.index')}}">Producto</a></li>
            <li class="active">{{ $producto->id }}</li>
            <ol>
    </section>

    <section class="content">
        <div class="box box-success">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Nombre</label>
                        <div>{{ $producto->productop_nombre }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-5">
                        <label class="control-label">Tipo de producto</label>
                        <div>{{ $producto->tipoproductop_nombre }}</div>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="control-label">Subipo de producto</label>
                        <div>{{ $producto->subtipoproductop_nombre }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Detalle</label>
                        <div>{{ $producto->productop_observaciones }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Abierto</label>
                        <div>
                            <input type="checkbox" id="productop_abierto" name="productop_abierto" value="productop_abierto" disabled {{ $producto->productop_abierto ? 'checked': '' }}>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Ancho</label>
                        <div>{{ $producto->m1_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Alto</label>
                        <div>{{ $producto->m2_nombre }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Cerrado</label>
                        <div>
                            <input type="checkbox" id="productop_cerrado" name="productop_cerrado" value="productop_cerrado" disabled {{ $producto->productop_cerrado ? 'checked': '' }}>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Ancho</label>
                        <div>{{ $producto->m3_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Alto</label>
                        <div>{{ $producto->m4_nombre }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">3D</label>
                        <div>
                            <input type="checkbox" id="productop_3d" name="productop_3d" value="productop_3d" disabled {{ $producto->productop_3d ? 'checked': '' }}>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Ancho</label>
                        <div>{{ $producto->m5_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Alto</label>
                        <div>{{ $producto->m6_nombre }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Profundidad</label>
                        <div>{{ $producto->m7_nombre }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Tiro</label>
                        <div>
                            <input type="checkbox" id="productop_tiro" name="productop_tiro" value="productop_tiro" disabled {{ $producto->productop_tiro ? 'checked': '' }}>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Retiro</label>
                        <div>
                            <input type="checkbox" id="productop_retiro" name="productop_retiro" value="productop_retiro" disabled {{ $producto->productop_retiro ? 'checked': '' }}>
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                            <a href=" {{ route('productosp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                            <a href="{{ route('productosp.edit', ['productosp' => $producto->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_areas" data-toggle="tab">Áreas involucradas</a></li>
                                <li><a href="#tab_tips" data-toggle="tab">Tips</a></li>
                                <li><a href="#tab_maquinas" data-toggle="tab">Máquinas</a></li>
                                <li><a href="#tab_materiales" data-toggle="tab">Materiales</a></li>
                                <li><a href="#tab_acabados" data-toggle="tab">Acabados</a></li>
                            </ul>

                            <div class="tab-content">
                                {{-- Content areas --}}
                                <div class="tab-pane active" id="tab_areas">
                                    <div class="box box-solid" id="wrapper-productop-areas">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-areas-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="100px">Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Render content areas --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content tips --}}
                                <div class="tab-pane" id="tab_tips">
                                    <div class="box box-solid" id="wrapper-productop-tips">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-tips-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="100px">Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Render content tips --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content maquinas --}}
                                <div class="tab-pane" id="tab_maquinas">
                                    <div class="box box-solid" id="wrapper-productop-maquinas">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-maquinas-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5px">Código</th>
                                                            <th width="95px">Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Render content maquinas --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content materiales --}}
                                <div class="tab-pane" id="tab_materiales">
                                    <div class="box box-solid" id="wrapper-productop-materiales">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-materiales-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5px">Código</th>
                                                            <th width="95px">Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Render content materiales --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content acabados --}}
                                <div class="tab-pane" id="tab_acabados">
                                    <div class="box box-solid" id="wrapper-productop-acabados">
                                        <div class="box-body">
                                            <!-- table table-bordered table-striped -->
                                            <div class="box-body table-responsive no-padding">
                                                <table id="browse-acabados-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5px">Código</th>
                                                            <th width="95px">Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Render content acabados --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
