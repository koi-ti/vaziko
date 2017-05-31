@extends('inventory.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Insumos</a></li>
    <li class="active">{{ $producto->producto_codigo }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $producto->producto_codigo }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Código proveedor</label>
                    <div>{{ $producto->producto_codigoori }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Referencia</label>
                    <div><a href="{{ route('productos.show', ['productos' => $producto->referencia_id]) }}" title="Ver referencia">{{ $producto->referencia_codigo }}</a></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $producto->producto_nombre }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Grupo</label>
                    <div>{{ $producto->grupo_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Subgrupo</label>
                    <div>{{ $producto->subgrupo_nombre }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Unidad de medida</label>
                    <div>{{ $producto->unidadmedida_nombre }} ({{ $producto->unidadmedida_sigla }})</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Vida útil</label>
                    <div>{{ $producto->producto_vidautil }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">¿Maneja unidades?</label>
                    <div>
                        <input type="checkbox" id="producto_unidades" name="producto_unidades" value="producto_unidades" disabled {{ $producto->producto_unidades ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">¿Meneja serie?</label>
                    <div>
                        <input type="checkbox" id="producto_serie" name="producto_serie" value="producto_serie" disabled {{ $producto->producto_serie ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">¿Producto metrado?</label>
                    <div>
                        <input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" disabled {{ $producto->producto_metrado ? 'checked': '' }}>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Precio</label>
                    <div class="text-right">{{ number_format($producto->producto_precio, 2, '.', ',') }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Costo promedio</label>
                    <div class="text-right">{{ number_format($producto->producto_costo, 2, '.', ',') }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('productos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    @if($producto->id == $producto->producto_referencia)
                        <a href="{{ route('productos.edit', ['productos' => $producto->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop