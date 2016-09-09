@extends('accounting.asiento.main')

@section('breadcrumb')
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
        <div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-4 col-xs-4 text-left">
					<a href="{{ route('asientos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
				</div>
				<div class="col-md-2 col-md-offset-6 col-sm-4 col-xs-4 text-right">
					<button type="button" class="btn btn-warning btn-sm btn-block pre-save-asiento">Posponer</button>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-4 text-right">
					<button type="button" class="btn btn-primary btn-sm btn-block submit-asiento">{{ trans('app.create') }}</button>
				</div>
			</div>
		</div>

		<div class="box-body" id="render-form-asientos">
			{{-- Render form asientos --}}
		</div>

		<!-- Modal facturap -->
		<div class="modal fade" id="modal-facturap-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4>Factura proveedor</h4>
					</div>
					{!! Form::open(['id' => 'form-create-facturap-component', 'data-toggle' => 'validator']) !!}
						<div class="modal-body box box-success">
							<div class="content-modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
							<button type="sutmi" class="btn btn-primary btn-sm">Continuar</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop