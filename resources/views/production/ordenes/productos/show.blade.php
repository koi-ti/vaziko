@extends('production.ordenes.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
	<li><a href="{{ route('ordenes.edit', ['ordenes' => $orden->id]) }}">{{ $orden->orden_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="ordenes-productos-create">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('ordenes.show', ['ordenes' => $orden->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @if($orden->orden_abierta)
	                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
	                    <a href="{{ route('ordenes.productos.edit', ['productos' => $ordenp2->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
	                </div>
	         	@endif
            </div>
        </div>

        <div class="box-body">
			<div class="row">
				<div class="form-group col-md-1">
					<label class="control-label">Código</label>
					<div>{{ $orden->orden_codigo }}</div>
				</div>
				<div class="form-group col-md-9">
					<label class="control-label">Producto</label>
					<div>{{ $ordenp2->productop_nombre }}</div>
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Cantidad</label>
					<div>{{ $ordenp2->orden2_cantidad }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Referencia</label>
					<div>{{ $ordenp2->orden2_referencia }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-10">
					<label class="control-label">Fórmula</label>
					<div>{{ $ordenp2->orden2_precio_formula }}</div>
				</div>

				<div class="form-group col-md-2">
					<label class="control-label">Redondear</label>
					<div>{{ $ordenp2->orden2_round_formula }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Referencia</label>
					<div>{{ number_format($ordenp2->orden2_precio_venta,2,'.',',') }}</div>
				</div>
			</div>

			@if($producto->productop_abierto || $producto->productop_cerrado)
				<div class="box box-primary">
                    <div class="box-body">
                        @if($producto->productop_abierto)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
                                <label for="orden2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                               			{{ $ordenp2->orden2_ancho }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
                                </div>

                                <label for="orden2_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        {{ $ordenp2->orden2_alto }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_cerrado)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
                                <label for="orden2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                               			{{ $ordenp2->orden2_c_ancho }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
                                </div>

                                <label for="orden2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        {{ $ordenp2->orden2_c_alto }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m4_sigla }}</div>
                                </div>
                            </div>
                        @endif
                 	</div>
               	</div>
			@endif

			@if($producto->productop_3d)
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <label class="col-sm-offset-1 col-sm-1 control-label">3D</label>
                            <label for="orden2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $ordenp2->orden2_3d_ancho }}
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
                            </div>

                            <label for="orden2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $ordenp2->orden2_3d_alto }}
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                            </div>

                            <label for="orden2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $ordenp2->orden2_3d_profundidad }}
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m7_sigla }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($producto->productop_tiro || $producto->productop_retiro)
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <label class="col-sm-offset-2 col-sm-1 col-xs-offset-2 col-xs-1 control-label"></label>
                            <label class="col-sm-1 col-xs-1 control-label">C</label>
                            <label class="col-sm-1 col-xs-1 control-label">M</label>
                            <label class="col-sm-1 col-xs-1 control-label">Y</label>
                            <label class="col-sm-1 col-xs-1 control-label">K</label>
                            <label class="col-sm-1 col-xs-1 control-label">P1</label>
                            <label class="col-sm-1 col-xs-1 control-label">P2</label>
                        </div>

                        @if($producto->productop_tiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1 col-xs-3">
                                    <label for="orden2_tiro" class="control-label">T</label>
                                    <input type="checkbox" disabled id="orden2_tiro" name="orden2_tiro" value="orden2_tiro" {{ $ordenp2->orden2_tiro ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_yellow" name="orden2_yellow" value="orden2_yellow" {{ $ordenp2->orden2_yellow ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_magenta" name="orden2_magenta" value="orden2_magenta" {{ $ordenp2->orden2_magenta ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_cyan" name="orden2_cyan" value="orden2_cyan" {{ $ordenp2->orden2_cyan ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_key" name="orden2_key" value="orden2_key" {{ $ordenp2->orden2_key ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_color1" name="orden2_color1" value="orden2_color1" {{ $ordenp2->orden2_color1 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_color2" name="orden2_color2" value="orden2_color2" {{ $ordenp2->orden2_color2 ? 'checked': '' }}>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_retiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1 col-xs-3">
                                    <label for="orden2_retiro" class="control-label">R</label>
                                    <input type="checkbox" disabled id="orden2_retiro" name="orden2_retiro" value="orden2_retiro" {{ $ordenp2->orden2_retiro ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_yellow2" name="orden2_yellow2" value="orden2_yellow2" {{ $ordenp2->orden2_yellow2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_magenta2" name="orden2_magenta2" value="orden2_magenta2" {{ $ordenp2->orden2_magenta2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_cyan2" name="orden2_cyan2" value="orden2_cyan2" {{ $ordenp2->orden2_cyan2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_key2" name="orden2_key2" value="orden2_key2" {{ $ordenp2->orden2_key2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_color12" name="orden2_color12" value="orden2_color12" {{ $ordenp2->orden2_color12 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="orden2_color22" name="orden2_color22" value="orden2_color22" {{ $ordenp2->orden2_color22 ? 'checked': '' }}>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            @if($producto->productop_tiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="orden2_nota_tiro" class="control-label">Nota tiro</label>
                                    <div>{{ $ordenp2->orden2_nota_tiro }}</div>
                                </div>
                            @endif

                            @if($producto->productop_retiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="orden2_nota_retiro" class="control-label">Nota retiro</label>
                                    <div>{{ $ordenp2->orden2_nota_retiro }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <label for="orden2_observaciones" class="col-sm-1 control-label">Detalle</label>
                <div class="form-group col-sm-12">
                	{{ $ordenp2->orden2_observaciones }}
                </div>
            </div>

            <br/>
            <div class="row">
                {{-- Content maquinas --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Máquinas</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Ordenp3::getOrdenesp3($producto->id, $ordenp2->id) as $maquina)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="orden3_maquinap_{{ $maquina->id }}">
                                            <input type="checkbox" id="orden3_maquinap_{{ $maquina->id }}" name="orden3_maquinap_{{ $maquina->id }}" value="orden3_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }} disabled> {{ $maquina->maquinap_nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Content materiales --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Ordenp4::getOrdenesp4($producto->id, $ordenp2->id) as $material)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="orden4_materialp_{{ $material->id }}">
                                            <input type="checkbox" id="orden4_materialp_{{ $material->id }}" name="orden4_materialp_{{ $material->id }}" value="orden4_materialp_{{ $material->id }}" {{ $material->activo ? 'checked': '' }} disabled> {{ $material->materialp_nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Content acabados --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Acabados</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Ordenp5::getOrdenesp5($producto->id, $ordenp2->id) as $acabado)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="orden5_acabadop_{{ $acabado->id }}">
                                            <input type="checkbox" id="orden5_acabadop_{{ $acabado->id }}" name="orden5_acabadop_{{ $acabado->id }}" value="orden5_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }} disabled> {{ $acabado->acabadop_nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
@stop