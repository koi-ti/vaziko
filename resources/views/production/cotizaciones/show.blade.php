@extends('production.cotizaciones.main')

@section('module')
	<section class="content-header">
		<h1>
			Cotizaciones <small>Administración de cotizaciones</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li><a href="{{ route('cotizaciones.index') }}">Cotizaciones</a></li>
			<li class="active">{{ $cotizacion->id }}</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="box box-success" id="cotizaciones-show">
			<div class="box-body">
				<div class="row">
					<div class="form-group col-md-2">
						<label for="cotizacion_codigo" class="control-label">Código</label>
						<div>
							{{ $cotizacion->cotizacion_codigo }}
							@if($cotizacion->cotizacion1_anulada)
	                            <span class="label label-danger">ANULADA</span>
	                        @elseif($cotizacion->cotizacion1_aprobada)
	                            <span class="label label-success">APROBADA</span>
	                        @else
	                            <span class="label label-warning">PENDIENTE</span>
	                        @endif
                       </div>
					</div>
					<div class="form-group col-md-2">
						<label for="cotizacion1_ano" class="control-label">Año</label>
						<div>{{ $cotizacion->cotizacion1_ano }}</div>
					</div>
					<div class="form-group col-md-2">
						<label for="cotizacion1_fecha" class="control-label">Fecha</label>
						<div>{{ $cotizacion->cotizacion1_fecha }}</div>
					</div>
					<div class="form-group col-md-2">
						<label for="cotizacion1_entrega" class="control-label">F. Entrega</label>
						<div>{{ $cotizacion->cotizacion1_entrega }}</div>
					</div>

					@if( Auth::user()->ability('admin', ['module' => 'cotizaciones']) )
                        <div class="form-group col-sm-4">
                            <div class="dropdown pull-right">
                                <a class="dropdown-toggle a-color" data-toggle="dropdown" href="#">
                                    Opciones <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="#" class="open-cotizacion">
                                            <i class="fa fa-unlock"></i>Reabrir Cotizacion
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						<label for="cotizacion1_cliente" class="control-label">Cliente</label>
						<div>
							Documento: <a href="{{ route('terceros.show', ['terceros' =>  $cotizacion->cotizacion1_cliente ]) }}">
								{{ $cotizacion->tercero_nit }}
							</a> <br> Nombre: {{ $cotizacion->tercero_nombre }}
						</div>
					</div>

					<div class="form-group col-md-6">
						<label for="cotizacion1_contacto" class="control-label">Contacto</label>
						<div>Nombre: {{ $cotizacion->tcontacto_nombre }} <br> Telefono: {{ $cotizacion->tcontacto_telefono }}</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-9">
						<label for="cotizacion1_descripcion" class="control-label">Descripcion</label>
						<div>{{ $cotizacion->cotizacion1_descripcion }}</div>
					</div>
				</div>

        		<div class="row">
					<div class="row">
		                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
		                    <a href=" {{ route('cotizaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
		                </div>
		            </div>
				</div><br>

				<div class="box box-success">
					<div class="box-body table-responsive">
						<table id="browse-cotizacion2-list" class="table table-bordered" cellspacing="0" width="100%">
							<thead>
					            <tr>
					                <th>Producto</th>
					                <th>Material</th>
					                <th>Medida</th>
					                <th>Cantidad</th>
					                <th>Valor</th>
					                <th>Total</th>
					            </tr>
				           </thead>
				            <tfoot>
								<tr>
									<td colspan="4"></td>
									<th class="text-right">Total</th>
									<th class="text-right" id="total">0</th>
								</tr>
							</tfoot>
					    </table>
					</div>
				</div>

				<div class="box box-success">
			        <div class="box-body table-responsive">
			            <table id="browse-cotizacion3-list" class="table table-bordered" cellspacing="0" width="100%">
			                <thead>
			                    <tr>
			                        <th>Área</th>
			                        <th>Nombre</th>
			                        <th>Horas</th>
			                        <th>Valor</th>
			                        <th>Total</th>
			                    </tr>
			                </thead>
			                <tfoot>
			                    <tr>
			                        <td colspan="3"></td>
			                        <th class="text-right">Total</th>
			                        <th class="text-right" id="total">0</th>
			                    </tr>
			                </tfoot>
			            </table>
			        </div>
		       	</div>
			</div>
		</div>
	</section>

	<script type="text/template" id="cotizacion-open-confirm-tpl">
        <p>¿Está seguro que desea reabrir la cotización <b> {{ $cotizacion->cotizacion_codigo }}</b>?</p>
    </script>
@stop