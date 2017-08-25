@extends('production.cotizaciones.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('cotizaciones.index') }}">Cotización</a></li>
	<li><a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}">{{ $cotizacion->cotizacion_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="cotizaciones-productos-create">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('cotizaciones.show', ['cotizaciones' => $cotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @if($cotizacion->cotizacion1_abierta)
	                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
	                    <a href="{{ route('cotizaciones.productos.edit', ['productos' => $cotizacion2->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
	                </div>
	         	@endif
            </div>
        </div>

        <div class="box-body">
			<div class="row">
				<div class="form-group col-md-1">
					<label class="control-label">Código</label>
					<div>{{ $cotizacion->cotizacion_codigo }}</div>
				</div>
				<div class="form-group col-md-9">
					<label class="control-label">Producto</label>
					<div>{{ $cotizacion2->productop_nombre }}</div>
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Cantidad</label>
					<div>{{ $cotizacion2->cotizacion2_cantidad }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					<label class="control-label">Referencia</label>
					<div>{{ $cotizacion2->cotizacion2_referencia }}</div>
				</div>
			</div>

            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
    			<div class="row">
    				<div class="form-group col-md-10">
    					<label class="control-label">Fórmula</label>
    					<div>{{ $cotizacion2->cotizacion2_precio_formula }}</div>
    				</div>

    				<div class="form-group col-md-2">
    					<label class="control-label">Redondear</label>
    					<div>{{ $cotizacion2->cotizacion2_round_formula }}</div>
    				</div>
    			</div>

    			<div class="row">
    				<div class="form-group col-md-12">
    					<label class="control-label">Referencia</label>
    					<div>{{ number_format($cotizacion2->cotizacion2_precio_venta,2,'.',',') }}</div>
    				</div>
    			</div>
            @endif

			@if($producto->productop_abierto || $producto->productop_cerrado)
				<div class="box box-primary">
                    <div class="box-body">
                        @if($producto->productop_abierto)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
                                <label for="cotizacion2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                               			{{ $cotizacion2->cotizacion2_ancho }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
                                </div>

                                <label for="cotizacion2_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        {{ $cotizacion2->cotizacion2_alto }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_cerrado)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
                                <label for="cotizacion2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                               			{{ $cotizacion2->cotizacion2_c_ancho }}
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
                                </div>

                                <label for="cotizacion2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        {{ $cotizacion2->cotizacion2_c_alto }}
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
                            <label for="cotizacion2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $cotizacion2->cotizacion2_3d_ancho }}
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
                            </div>

                            <label for="cotizacion2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $cotizacion2->cotizacion2_3d_alto }}
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                            </div>

                            <label for="cotizacion2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                	{{ $cotizacion2->cotizacion2_3d_profundidad }}
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
                                    <label for="cotizacion2_tiro" class="control-label">T</label>
                                    <input type="checkbox" disabled id="cotizacion2_tiro" name="cotizacion2_tiro" value="cotizacion2_tiro" {{ $cotizacion2->cotizacion2_tiro ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_yellow" name="cotizacion2_yellow" value="cotizacion2_yellow" {{ $cotizacion2->cotizacion2_yellow ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_magenta" name="cotizacion2_magenta" value="cotizacion2_magenta" {{ $cotizacion2->cotizacion2_magenta ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_cyan" name="cotizacion2_cyan" value="cotizacion2_cyan" {{ $cotizacion2->cotizacion2_cyan ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_key" name="cotizacion2_key" value="cotizacion2_key" {{ $cotizacion2->cotizacion2_key ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_color1" name="cotizacion2_color1" value="cotizacion2_color1" {{ $cotizacion2->cotizacion2_color1 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_color2" name="cotizacion2_color2" value="cotizacion2_color2" {{ $cotizacion2->cotizacion2_color2 ? 'checked': '' }}>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_retiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1 col-xs-3">
                                    <label for="cotizacion2_retiro" class="control-label">R</label>
                                    <input type="checkbox" disabled id="cotizacion2_retiro" name="cotizacion2_retiro" value="cotizacion2_retiro" {{ $cotizacion2->cotizacion2_retiro ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_yellow2" name="cotizacion2_yellow2" value="cotizacion2_yellow2" {{ $cotizacion2->cotizacion2_yellow2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_magenta2" name="cotizacion2_magenta2" value="cotizacion2_magenta2" {{ $cotizacion2->cotizacion2_magenta2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_cyan2" name="cotizacion2_cyan2" value="cotizacion2_cyan2" {{ $cotizacion2->cotizacion2_cyan2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_key2" name="cotizacion2_key2" value="cotizacion2_key2" {{ $cotizacion2->cotizacion2_key2 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_color12" name="cotizacion2_color12" value="cotizacion2_color12" {{ $cotizacion2->cotizacion2_color12 ? 'checked': '' }}>
                                </div>
                                <div class="col-md-1 col-xs-1">
                                    <input type="checkbox" disabled id="cotizacion2_color22" name="cotizacion2_color22" value="cotizacion2_color22" {{ $cotizacion2->cotizacion2_color22 ? 'checked': '' }}>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            @if($producto->productop_tiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="cotizacion2_nota_tiro" class="control-label">Nota tiro</label>
                                    <div>{{ $cotizacion2->cotizacion2_nota_tiro }}</div>
                                </div>
                            @endif

                            @if($producto->productop_retiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="cotizacion2_nota_retiro" class="control-label">Nota retiro</label>
                                    <div>{{ $cotizacion2->cotizacion2_nota_retiro }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <label for="cotizacion2_observaciones" class="col-sm-1 control-label">Detalle</label>
                <div class="form-group col-sm-12">
                	{{ $cotizacion2->cotizacion2_observaciones }}
                </div>
            </div>

            <br/>

            <div class="row">
				{{-- Content materiales --}}
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Areas</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Cotizacion6::getCotizaciones6($producto->id, $cotizacion2->id) as $areap)
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label class="checkbox-inline without-padding white-space-normal" for="cotizacion6_areap_{{ $areap->id }}">
                                            <input type="checkbox" id="cotizacion6_areap_{{ $areap->id }}" name="cotizacion6_areap_{{ $areap->id }}" value="cotizacion6_areap_{{ $areap->id }}" {{ $areap->activo ? 'checked': '' }} disabled> {{ $areap->areap_nombre }}
                                        </label>
                                    </div>
									<div class="form-group col-sm-3" >
							            <input id="cotizacion6_nombre_{{ $areap->id }}" disabled name="cotizacion6_nombre_{{ $areap->id }}" placeholder="Nombre" class="form-control input-sm input-toupper" value="{{ $areap->cotizacion6_nombre }}" type="text" maxlength="20">
							        </div>

							        <div class="form-group col-sm-3">
							            <input id="cotizacion6_horas_{{ $areap->id }}" disabled name="cotizacion6_horas_{{ $areap->id }}" placeholder="Horas" class="form-control input-sm item-area" value="{{ $areap->cotizacion6_horas }}" type="number" step="1">
							        </div>

							        <div class="form-group col-sm-3">
							            <input id="cotizacion6_valor_{{ $areap->id }}" disabled name="cotizacion6_valor_{{ $areap->id }}" placeholder="Valor" class="form-control input-sm item-area" value="{{ $areap->cotizacion6_valor }}" type="text" data-currency>
							        </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Content materiales --}}
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Cotizacion4::getCotizaciones4($producto->id, $cotizacion2->id) as $material)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="cotizacion4_materialp_{{ $material->id }}">
                                            <input type="checkbox" id="cotizacion4_materialp_{{ $material->id }}" name="cotizacion4_materialp_{{ $material->id }}" value="cotizacion4_materialp_{{ $material->id }}" {{ $material->activo ? 'checked': '' }} disabled> {{ $material->materialp_nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

			<div class="row">
                {{-- Content acabados --}}
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Acabados</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Cotizacion5::getCotizaciones5($producto->id, $cotizacion2->id) as $acabado)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="cotizacion5_acabadop_{{ $acabado->id }}">
                                            <input type="checkbox" id="cotizacion5_acabadop_{{ $acabado->id }}" name="cotizacion5_acabadop_{{ $acabado->id }}" value="cotizacion5_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }} disabled> {{ $acabado->acabadop_nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

				{{-- Content maquinas --}}
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Máquinas</h3>
                        </div>
                        <div class="box-body">
                            @foreach( App\Models\Production\Cotizacion3::getCotizaciones3($producto->id, $cotizacion2->id) as $maquina)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="checkbox-inline without-padding white-space-normal" for="cotizacion3_maquinap_{{ $maquina->id }}">
                                            <input type="checkbox" id="cotizacion3_maquinap_{{ $maquina->id }}" name="cotizacion3_maquinap_{{ $maquina->id }}" value="cotizacion3_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }} disabled> {{ $maquina->maquinap_nombre }}
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
