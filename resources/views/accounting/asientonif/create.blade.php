@extends('accounting.asientonif.main')

@section('module')
	<div id="asientosnif-create"></div>

	<div id="asiento-content">
		<!-- Modal facturap -->
		<div class="modal fade" id="modal-asiento-facturap-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header small-box {{ config('koi.template.bg') }}">
						<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="inner-title-modal modal-title">Factura proveedor</h4>
					</div>
					{!! Form::open(['id' => 'form-create-asiento-component-source', 'data-toggle' => 'validator']) !!}
						<div class="modal-body" id="modal-asiento-wrapper-facturap">
							<div id="error-eval-facturap" class="alert alert-danger"></div>
							<div class="content-modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>

		<!-- Modal cartera -->
		<div class="modal fade" id="modal-asiento-cartera-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-xlg" role="document">
				<div class="modal-content">
					<div class="modal-header small-box {{ config('koi.template.bg') }}">
						<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="inner-title-modal modal-title">Cartera</h4>
					</div>
					{!! Form::open(['id' => 'form-create-cartera-component-source', 'data-toggle' => 'validator']) !!}
						<div class="modal-body" id="modal-asiento-wrapper-cartera">
							<div id="error-eval-cartera" class="alert alert-danger"></div>
							<div class="content-modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>

		<!-- Modal ordenp -->
		<div class="modal fade" id="modal-asiento-ordenp-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header small-box {{ config('koi.template.bg') }}">
						<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="inner-title-modal modal-title">Ordenes de producción</h4>
					</div>
					{!! Form::open(['id' => 'form-create-ordenp-asiento-component-source', 'class' => 'form-horizontal', 'data-toggle' => 'validator']) !!}
						<div class="modal-body" id="modal-asiento-wrapper-ordenp">
							<div id="error-search-orden-asiento2" class="alert alert-danger"></div>
							<div class="content-modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>

		<!-- Modal inventario -->
		<div class="modal fade" id="modal-asiento-inventario-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header small-box {{ config('koi.template.bg') }}">
						<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="inner-title-modal modal-title">Inventario</h4>
					</div>
					{!! Form::open(['id' => 'form-create-inventario-asiento-component-source', 'data-toggle' => 'validator']) !!}
						<div class="modal-body" id="modal-asiento-wrapper-inventario">
							<div id="error-inventario-asiento2" class="alert alert-danger"></div>
							<div class="content-modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop
