@extends('production.cotizaciones.main')

@section('module')
	<div id="cotizaciones-create"></div>

	<div id="cotizaciones-content">
		<div class="modal fade" id="modal-producto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	        <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	                <div class="modal-header small-box {{ config('koi.template.bg') }}">
	                        <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
	                        <h4 class="inner-title-modal modal-title"></h4>
	                    </div>
	                {!! Form::open(['id' => 'form-producto-component', 'data-toggle' => 'validator']) !!}
	                    <div class="modal-body" >
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