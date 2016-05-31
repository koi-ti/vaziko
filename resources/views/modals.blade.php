<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-create-resource-component">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-create-resource-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div id="error-resource-component" class="alert alert-danger"></div>
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

<!-- Modal address -->
<div class="modal fade" id="modal-address-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

{{-- templates --}}
<script type="text/template" id="koi-address-component-tpl">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Generador de direcciones</h4>
	</div>
	{!! Form::open(['id' => 'form-address-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	<div class="modal-body">
		<div class="form-group">
			<label for="koi_municipio_codigo" class="col-md-2 control-label">Municipio</label>
			<div class="col-md-6">
			{!! Form::select('koi_municipio_codigo', App\Models\Base\Municipio::getMunicipios(), null, ['id' => 'koi_municipio_codigo', 'class' => 'form-control select2-default', 'required']) !!}
			</div>
		</div>
		
		<div class="form-group">
			<label for="koi_direccion" class="col-md-2 control-label">Dirección</label>
			<div class="col-md-8">
				{!! Form::text('koi_direccion', null, ['id' => 'koi_direccion', 'class' => 'form-control input-sm', 'disabled']) !!}       
			</div>
			<div class="col-md-2">
				<a href="#" class="btn btn-default btn-sm btn-address-component-remove-item">
					<span><i class="fa fa-minus"></i> Borrar</span>
				</a>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<p>Diligencie los campos que identifiquen la dirección actual; los campos que no requiera los puede dejar en blanco. Vaya verificando en el recuadro superior su dirección</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-2">
				{!! Form::select('koi_nomenclatura1', ['' => 'Seleccione'] + config('koi.direcciones.nomenclatura'), null, ['id' => 'koi_nomenclatura1', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::text('koi_numero1', null, ['id' => 'koi_numero1', 'class' => 'form-control input-sm']) !!}       
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_alfabeto1', ['' => ''] + config('koi.direcciones.alfabeto'), null, ['id' => 'koi_alfabeto1', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_bis', ['' => '', 'BIS' => 'BIS'], null, ['id' => 'koi_bis', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_alfabeto2', ['' => ''] + config('koi.direcciones.alfabeto'), null, ['id' => 'koi_alfabeto2', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_cardinales1', ['' => ''] + config('koi.direcciones.cardinales'), null, ['id' => 'koi_cardinales1', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::text('koi_numero2', null, ['id' => 'koi_numero2', 'class' => 'form-control input-sm']) !!}       
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_alfabeto3', ['' => ''] + config('koi.direcciones.alfabeto'), null, ['id' => 'koi_alfabeto3', 'class' => 'form-control']) !!}
			</div>
			<div class="col-md-1">
				{!! Form::text('koi_numero3', null, ['id' => 'koi_numero3', 'class' => 'form-control input-sm']) !!}       
			</div>
			<div class="col-md-1">
				{!! Form::select('koi_cardinales2', ['' => ''] + config('koi.direcciones.cardinales'), null, ['id' => 'koi_cardinales2', 'class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-12">
				<p>Seleccione el tipo en la lista desplegable inferior, escriba en el recuadro el detalle y pulse el botón "Adicionar otro complemento". Repita este proceso hasta tener toda la parte complementaria de la dirección y vaya verificando en el recuadro superior su dirección</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3">
				{!! Form::select('koi_complementos1', ['' => 'Seleccione'] + config('koi.direcciones.complementos'), null, ['id' => 'koi_complementos1', 'class' => 'form-control']) !!}
			</div>	
			<div class="col-md-4">
				{!! Form::text('koi_complementos2', null, ['id' => 'koi_complementos2', 'class' => 'form-control input-sm input-toupper']) !!}       
			</div>
			<div class="col-md-2">
				<a href="#" class="btn btn-default btn-sm btn-address-component-add-complement">
					<span><i class="fa fa-plus"></i> Agregar</span>
				</a>
			</div>	
		</div>

		<div class="form-group">
			<label for="koi_postal" class="col-md-2 control-label">Codigo Postal</label>
			<div class="col-md-3">
				{!! Form::text('koi_postal', null, ['id' => 'koi_postal', 'class' => 'form-control input-sm input-toupper']) !!}       
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
		<button type="submit" class="btn btn-primary btn-sm btn-address-component-add-address">Continuar</button>
	</div>
	{!! Form::close() !!}
</script>