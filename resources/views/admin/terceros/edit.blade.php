@extends('admin.terceros.main')

@section('breadcrumb')	
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">Editar ({{ $tercero->tercero_nit }})</li>
@stop

@section('module')
	<div class="box box-success" id="tercero-create">
	 	{!! Form::model($tercero, ['route' => ['terceros.edit', $tercero->id], 'id' => 'form-create-tercero', 'data-toggle' => 'validator']) !!}			
			
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('terceros.show', ['terceros' => $tercero->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>

			{{-- Include form tercero --}}
			@include('admin.terceros.form')

		{!! Form::close() !!}
	</div>

    <div class="row">
    	<div class="form-group col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_contactos" data-toggle="tab">Contactos</a></li>
					<li><a href="#tab_usuario" data-toggle="tab">Usuario</a></li>
				</ul>
				<div class="tab-content">
					
					{{-- Tab contactos --}}
					<div class="tab-pane active" id="tab_contactos">
						<div class="box">
							<div class="box-body table-responsive no-padding">
								<table id="browse-contact-list" class="table table-hover">	
									{{-- Render contact list --}}						
								</table>
							</div>
						</div>
					</div>
					
					{{-- Tab usuario --}}
					<div class="tab-pane" id="tab_usuario">
						Cuenta de usuario
					</div>
				
				</div>
			</div>
		</div>
    </div>
@stop